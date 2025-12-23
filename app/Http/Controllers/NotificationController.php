<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Show the notifications page with all history.
     */
    public function index()
    {
        // Get all notifications (read and unread), paginated
        $notifications = Auth::user()->notifications()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    /**
     * Delete a single notification.
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
        }

        return back()->with('success', 'Notification removed.');
    }
}
