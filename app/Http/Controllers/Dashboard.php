<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $type_menu = 'dashboard';

        return view("pages.dashboard-general-dashboard", ['type_menu'=> $type_menu]);
    }
}
