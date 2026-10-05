<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of user notifications.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $notifications = $user->notifications()
            ->latest()
            ->paginate(20);

        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark a specific notification as read and navigate to its target.
     */
    public function read(Request $request, string $id)
    {
        $user = auth()->user();

        /** @var DatabaseNotification $notification */
        $notification = $user->notifications()->findOrFail($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        $unreadCount = $user->unreadNotifications()->count();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount,
            ]);
        }

        // Navigate to the related ticket if available
        if (isset($notification->data['ticket_id'])) {
            $ticketId = $notification->data['ticket_id'];

            if ($user->role === 'admin') {
                return redirect()->route('admin.tickets.show', $ticketId);
            }

            return redirect()->route('tickets.show', $ticketId);
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Mark all unread notifications for the user as read.
     */
    public function markAllAsRead(Request $request)
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'unread_count' => 0,
            ]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Return current unread notification count.
     */
    public function unreadCount(Request $request)
    {
        return response()->json([
            'unread_count' => auth()->user()->unreadNotifications()->count(),
        ]);
    }
}
