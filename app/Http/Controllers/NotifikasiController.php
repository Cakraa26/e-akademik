<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotifikasiController extends Controller
{
    public function notif()
    {
        $type_menu = 'notif';
        $residenId = auth()->user()->pk;
        $notifikasi = Notification::where('residenfk', $residenId)
            ->where('pengumumanfk', null)
            ->where('is_read', 0)
            ->where('is_remove', 0)
            ->orderBy('dateadded', 'desc')
            ->get();
        return view("residen.notif", [
            'notifikasi' => $notifikasi,
            'type_menu' => $type_menu,
        ]);
    }
}

