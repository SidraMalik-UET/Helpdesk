<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use App\Notifications\TicketCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notifications_page_displays_unread_notifications(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'Support']);
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'subject' => 'My issue',
            'description' => 'Help needed',
            'priority' => 'medium',
            'status' => 'open',
        ]);

        $user->notify(new TicketCreated($ticket));

        $this->assertEquals(1, $user->unreadNotifications()->count());

        $response = $this->actingAs($user)->get(route('notifications.index'));
        $response->assertStatus(200);
        $response->assertSee('My issue');
        $response->assertSee('Mark All as Read (1)');
    }

    public function test_opening_single_notification_marks_only_that_notification_as_read_and_redirects(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'Billing']);

        $ticket1 = Ticket::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'subject' => 'Issue 1',
            'description' => 'Help 1',
            'priority' => 'low',
            'status' => 'open',
        ]);

        $ticket2 = Ticket::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'subject' => 'Issue 2',
            'description' => 'Help 2',
            'priority' => 'low',
            'status' => 'open',
        ]);

        $user->notify(new TicketCreated($ticket1));
        $user->notify(new TicketCreated($ticket2));

        $this->assertEquals(2, $user->unreadNotifications()->count());

        $notificationToRead = $user->unreadNotifications()->first();
        $otherNotification = $user->unreadNotifications()->get()->last();

        $response = $this->actingAs($user)->get(route('notifications.read', $notificationToRead->id));

        // Redirects to customer ticket show page
        $response->assertRedirect(route('tickets.show', $notificationToRead->data['ticket_id']));

        // Re-check database state
        $user->refresh();
        $this->assertEquals(1, $user->unreadNotifications()->count());
        $this->assertNotNull($notificationToRead->fresh()->read_at);
        $this->assertNull($otherNotification->fresh()->read_at);
    }

    public function test_admin_is_redirected_to_admin_ticket_view_when_opening_ticket_notification(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'Technical']);

        $ticket = Ticket::create([
            'user_id' => $customer->id,
            'category_id' => $category->id,
            'subject' => 'Server down',
            'description' => 'Outage',
            'priority' => 'urgent',
            'status' => 'open',
        ]);

        $admin->notify(new TicketCreated($ticket));
        $notification = $admin->unreadNotifications()->first();

        $response = $this->actingAs($admin)->get(route('notifications.read', $notification->id));
        $response->assertRedirect(route('admin.tickets.show', $ticket->id));
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_mark_all_as_read_marks_all_notifications_as_read(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'General']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'subject' => 'Help',
            'description' => 'Help',
            'priority' => 'low',
            'status' => 'open',
        ]);

        $user->notify(new TicketCreated($ticket));
        $user->notify(new TicketCreated($ticket));

        $this->assertEquals(2, $user->unreadNotifications()->count());

        $response = $this->actingAs($user)->post(route('notifications.markAllAsRead'));
        $response->assertRedirect();

        $this->assertEquals(0, $user->unreadNotifications()->count());
    }

    public function test_ajax_read_returns_json_with_updated_unread_count(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $category = TicketCategory::create(['name' => 'Support']);
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'subject' => 'Test',
            'description' => 'Test',
            'priority' => 'medium',
            'status' => 'open',
        ]);

        $user->notify(new TicketCreated($ticket));
        $notification = $user->unreadNotifications()->first();

        $response = $this->actingAs($user)
            ->getJson(route('notifications.read', $notification->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'unread_count' => 0,
        ]);
        $this->assertNotNull($notification->fresh()->read_at);
    }
}
