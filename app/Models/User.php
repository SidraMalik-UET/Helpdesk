<?php 

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable; 

class User extends Authenticatable 
{ 
    use HasFactory, Notifiable; 

    protected $fillable = [ 
        'name', 
        'email', 
        'password', 
        'role', 
        'status', 
    ]; 

    protected function casts(): array 
    { 
        return [ 
            'email_verified_at' => 'datetime', 
            'password' => 'hashed', 
        ]; 
    } 

    public function tickets() 
    { 
        return $this->hasMany(Ticket::class); 
    } 

    public function ticketReplies() 
    { 
        return $this->hasMany(TicketReply::class); 
    } 

    public function ticketAttachments() 
    { 
        return $this->hasMany(TicketAttachment::class); 
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }
}

