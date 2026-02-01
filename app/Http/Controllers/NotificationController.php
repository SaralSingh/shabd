<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Get current user
        $user = Auth::user();

        // Fetch all notifications (you can limit if needed)
        $notifications = $user->notifications;

        // Mark unread as read
        $user->unreadNotifications->markAsRead();

        // Return a view with notifications
        return view('User.notifications.index', compact('notifications'));
    }
}
