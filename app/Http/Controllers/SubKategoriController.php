<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    public function store(Request $request)
    {
        try {
            $subkategori = SubKategori::create($request->all());

            return back()->with('success', __('message.success_subkategori_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
