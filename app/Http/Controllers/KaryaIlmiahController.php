<?php

namespace App\Http\Controllers;

use App\Models\KaryaIlmiah;
use Illuminate\Http\Request;

class KaryaIlmiahController extends Controller
{
    public function index()
    {
        $type_menu = 'karyailmiah';
        $karya = KaryaIlmiah::all();
        return view("page.karya-ilmiah.index", [
            'karya' => $karya,
            'type_menu' => $type_menu,
        ]);
    }
}
