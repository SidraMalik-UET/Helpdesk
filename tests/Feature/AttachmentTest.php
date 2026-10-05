<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttachmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_ticket_owner_can_view_attachment(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'General Support']);

        $ticket = Ticket::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'subject' => 'Test Ticket',
            'description' => 'Test Description',
            'priority' => 'medium',
            'status' => 'open',
        ]);

        $file = UploadedFile::fake()->create('photo.jpg', 100, 'image/jpeg');
        $path = $file->store('ticket-attachments', 'public');

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $owner->id,
            'file_name' => 'photo.jpg',
            'file_path' => $path,
            'file_type' => 'image/jpeg',
            'file_size' => $file->getSize(),
        ]);

        $response = $this->actingAs($owner)->get(route('tickets.attachments.show', [$ticket, $attachment]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');
    }

    public function test_admin_and_assigned_agent_can_view_attachment(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $admin = User::factory()->create(['role' => 'admin']);
        $category = TicketCategory::create(['name' => 'Billing']);

        $ticket = Ticket::create([
            'user_id' => $owner->id,
            'assigned_to' => $agent->id,
            'category_id' => $category->id,
            'subject' => 'Test Ticket',
            'description' => 'Test Description',
            'priority' => 'high',
            'status' => 'open',
        ]);

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $path = $file->store('ticket-attachments', 'public');

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $owner->id,
            'file_name' => 'document.pdf',
            'file_path' => $path,
            'file_type' => 'application/pdf',
            'file_size' => 100,
        ]);

        // Agent can view
        $this->actingAs($agent)
            ->get(route('tickets.attachments.show', [$ticket, $attachment]))
            ->assertStatus(200);

        // Admin can view
        $this->actingAs($admin)
            ->get(route('tickets.attachments.show', [$ticket, $attachment]))
            ->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_view_attachment(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $otherUser = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'Billing']);

        $ticket = Ticket::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'subject' => 'Test Ticket',
            'description' => 'Test Description',
            'priority' => 'low',
            'status' => 'open',
        ]);

        $file = UploadedFile::fake()->create('secret.png', 100, 'image/png');
        $path = $file->store('ticket-attachments', 'public');

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $owner->id,
            'file_name' => 'secret.png',
            'file_path' => $path,
            'file_type' => 'image/png',
            'file_size' => $file->getSize(),
        ]);

        $this->actingAs($otherUser)
            ->get(route('tickets.attachments.show', [$ticket, $attachment]))
            ->assertStatus(403);
    }

    public function test_missing_attachment_file_returns_404(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'General']);

        $ticket = Ticket::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'subject' => 'Test',
            'description' => 'Desc',
            'priority' => 'low',
            'status' => 'open',
        ]);

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $owner->id,
            'file_name' => 'nonexistent.jpg',
            'file_path' => 'ticket-attachments/missing.jpg',
            'file_type' => 'image/jpeg',
            'file_size' => 1234,
        ]);

        $this->actingAs($owner)
            ->get(route('tickets.attachments.show', [$ticket, $attachment]))
            ->assertStatus(404);
    }

    public function test_can_upload_attachment_on_ticket_creation(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'General']);

        $file = UploadedFile::fake()->create('contract.pdf', 100, 'application/pdf');

        $response = $this->actingAs($owner)->post(route('tickets.store'), [
            'category_id' => $category->id,
            'subject' => 'Ticket with attachment',
            'description' => 'Here is my document',
            'priority' => 'urgent',
            'attachment' => $file,
        ]);

        $response->assertRedirect(route('tickets.index'));

        $ticket = Ticket::where('subject', 'Ticket with attachment')->first();
        $this->assertNotNull($ticket);
        $this->assertEquals('urgent', $ticket->priority);

        $attachment = TicketAttachment::where('ticket_id', $ticket->id)->first();
        $this->assertNotNull($attachment);
        $this->assertNull($attachment->reply_id);
        $this->assertEquals('contract.pdf', $attachment->file_name);
        $this->assertTrue($attachment->isPdf());
    }

    public function test_can_upload_attachment_on_ticket_reply(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'General']);

        $ticket = Ticket::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'subject' => 'Ticket for reply',
            'description' => 'Need reply',
            'priority' => 'medium',
            'status' => 'open',
        ]);

        $file = UploadedFile::fake()->create('screenshot.png', 100, 'image/png');

        $response = $this->actingAs($owner)->post(route('tickets.reply', $ticket), [
            'message' => 'Here is the screenshot',
            'attachment' => $file,
        ]);

        $response->assertRedirect(route('tickets.show', $ticket));

        $attachment = TicketAttachment::where('ticket_id', $ticket->id)
            ->whereNotNull('reply_id')
            ->first();

        $this->assertNotNull($attachment);
        $this->assertEquals('screenshot.png', $attachment->file_name);
        $this->assertTrue($attachment->isImage());
    }
}
