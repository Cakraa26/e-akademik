<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dosen extends Controller
{
    public function index()
    {
        return view("components.page.data-dosen.index");
    }
}
