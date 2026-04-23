<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get unread notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['notifications' => []], 401);
        }

        $notifications = $user->unreadNotifications()->latest()->take(10)->get();

        return response()->json([
            'count' => $user->unreadNotifications()->count(),
            'notifications' => $notifications->map(function($notif) {
                return [
                    'id' => $notif->id,
                    'type' => $notif->type,
                    'data' => $notif->data,
                    'created_at' => $notif->created_at->diffForHumans(),
                ];
            })
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $user = auth()->user();
        if ($user) {
            $notification = $user->unreadNotifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }
}
