<?php

namespace App\Http\Controllers;

use App\Models\HariKerja;
use Illuminate\Http\Request;

class HariKerjaController extends Controller
{
    public function index()
    {
        $type_menu = 'setting';
        $hr = HariKerja::all();
        return view("page.hari-kerja.index", [
            'thn' => $hr,
            'type_menu' => $type_menu,
        ]);

    }

    public function create()
    {
        $type_menu = 'setting';
        return view("page.hari-kerja.create", [
            'type_menu' => $type_menu,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm' => 'required'
        ], [
            'nm' => __('message.nama'),
            'jammasuk' => 'required'
        ], [
            'jammasuk' => __('message.jammasuk'),
            'jamselesai' => 'required'
        ], [
            'jamselesai' => __('message.jamselesai'),
        ]);

        try {
            $HariData = $request->all();
            $HariData['aktif'] = $request->has('aktif') ? 1 : 0;

            HariKerja::create([
                'nm' => $HariData ['nm'],
                'jammasuk' => $HariData ['jammasuk'],
                'jamselesai' => $HariData ['jamselesai'],
                'stsaktif' => $HariData ['aktif']
            ]);
            return redirect()
                ->route('hari.kerja.index')
                ->with('success', __('message.success_harikerja_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($pk)
    {
        $type_menu = 'setting';
        $hr = HariKerja::findOrFail($pk);
        return view("page.hari-kerja.edit", [
            'thn' => $hr,
            'type_menu' => $type_menu,
        ]);
    }

    public function update(Request $request, $pk)
    {
        $hr = HariKerja::findOrFail($pk);

        $request->validate([
            'nm' => 'required'
        ], [
            'nm' => __('message.nama'),
            'jammasuk' => 'required'
        ], [
            'jammasuk' => __('message.jammasuk'),
            'jamselesai' => 'required'
        ], [
            'jamselesai' => __('message.jamselesai'),
        ]);

        try {
            $HariData = $request->all();
            $HariData['aktif'] = $request->has('aktif') ? 1 : 0;

            $hr->update([
                'nm' => $HariData ['nm'],
                'jammasuk' => $HariData ['jammasuk'],
                'jamselesai' => $HariData ['jamselesai'],
                'stsaktif' => $HariData ['aktif']
            ]);
            return redirect()
                ->route('hari.kerja.index')
                ->with('success', __('message.success_harikerja_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($pk)
    {
        try {
            $HariData = HariKerja::findOrFail($pk);
            $HariData->delete();


            return redirect()
                ->route('hari.kerja.index')
                ->with('success', __('message.success_harikerja_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
