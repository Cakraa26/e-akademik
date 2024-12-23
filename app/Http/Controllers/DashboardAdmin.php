<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Residen;
use Illuminate\Http\Request;

class DashboardAdmin extends Controller
{
    public function index(){
        $type_menu = 'dashboard';
        $residenBaru = Residen::where('statuskuliah', 0)->count();
        $residenAktif = Residen::where('aktif', 1)->count();
        $alumni = Residen::where('statuskuliah', 3)->count();
        $count = Residen::where('statuskuliah', 0)
            ->where('aktif', 0)
            ->whereYear('dateadded', Carbon::now()->year) 
            ->count();
        return view("pages.dashboard-general-dashboard", [
            'residenBaru' => $residenBaru,
            'residenAktif' => $residenAktif,
            'alumni' => $alumni,
            'count' => $count,
            'type_menu' => $type_menu,
        ]);
    }
}
