<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\AdminNotification;

class NotificationController extends Controller
{

    public function index()
{
    $notifications = AdminNotification::where('read', 0)
        ->whereDate('created_at', today())
        ->get();

    $unreadCount = $notifications->count();

    return response()->json(['notifications' => $notifications, 'unreadCount' => $unreadCount]);
}

public function getUnreadCount()
{
    $notifCount = AdminNotification::where('read', 0)
        ->whereDate('created_at', today())
        ->count();

    return view('partials.nav', ['notifCount' => $notifCount]);
}

   public function markAllAsRead()
{
    $notifs = AdminNotification::where('read', 0)->whereDate('created_at', today())->get();
    foreach ($notifs as $notif) {
        $notif->update(['read' => 1]);
    }
    return response()->json(['success' => true]);
} 

}
