<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Mahasiswa extends Controller
{
    public function index()
    {
        return view("components.page.data-mahasiswa.index");
    }
}
