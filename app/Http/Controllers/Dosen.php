<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dosen extends Controller
{
    public function index()
    {
        return view("page.data-dosen.index");
    }
    public function create()
    {
        return view("page.data-dosen.create");
    }
}
