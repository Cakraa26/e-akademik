<?php

namespace App\Http\Controllers;

use App\Models\KaryaIlmiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class KaryaIlmiahResiden extends Controller
{
    public function index()
    {
        $type_menu = 'karyailmiah';
        $karya = KaryaIlmiah::all();
        $nama = Session::get('nm');
        $semester = Session::get('semester');
        $tingkat = Session::get('tingkat');
        // $residen = Auth::user(); 
        // $tkaryailmiah = $residen->tkaryailmiah;
        return view("page.karya-ilmiah-residen.index", [
            'karya' => $karya,
            'nama' => $nama,
            'semester' => $semester,
            'tingkat' => $tingkat,
            // 'tkaryailmiah' => $tkaryailmiah,
            'type_menu' => $type_menu,
        ]);
    }
}
