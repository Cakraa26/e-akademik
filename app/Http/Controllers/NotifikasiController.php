<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function notif()
    {
        $type_menu = 'notif';
        $residenId = auth()->user()->pk; 
            $notifikasi = Notification::where('residenfk', $residenId)
                ->orderBy('dateadded', 'desc')
                ->get();
        return view("residen.notif", [
            'notifikasi' => $notifikasi,
            'type_menu' => $type_menu,
        ]);
    }
}

