<?php

namespace App\Http\Controllers\API\Resident;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotification()
    {
        try {
            $notifications = Notification::where('residenfk', auth()->user()->pk)
                ->where('pengumumanfk', null)
                ->where('is_remove', 0)
                ->orderBy('dateadded', 'desc')
                ->get();

            return response()->json(['data' => $notifications], 200);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function readNotification($id)
    {
        try {
            $notification = Notification::find($id);
            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();

            return response()->json($notification, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function removeNotification($id)
    {
        try {
            $notification = Notification::find($id);
            $notification->is_remove = true;
            $notification->remove_at = now();
            $notification->save();

            return response()->json($notification, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getAnnouncement()
    {
        try {
            $announcements = Notification::with(['pengumuman'])
                ->whereHas('pengumuman', function ($query) {
                    $query->where('aktif', 1)
                        ->whereDate('tglbuat', '<=', now())
                        ->whereDate('tglsampai', '>=', now());
                })
                ->where('residenfk', auth()->user()->pk)
                ->where('pengumumanfk', '!=', null)
                ->orderBy('dateadded', 'desc')
                ->get();

            return response()->json($announcements, 200);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
