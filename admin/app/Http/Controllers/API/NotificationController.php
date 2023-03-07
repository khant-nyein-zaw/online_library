<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // get all notifications for authenticated user
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        return response()->json([
            'notifications' => $notifications
        ]);
    }

    public function markNotification(Request $request)
    {
        $notification = auth()->user()->notifications()->firstWhere('id', $request->id);
        $notification->markAsRead();
        return response()->noContent();
    }
}
