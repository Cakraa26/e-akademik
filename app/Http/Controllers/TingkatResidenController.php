<?php

namespace App\Http\Controllers;

use App\Models\TingkatResiden;
use Illuminate\Http\Request;

class TingkatResidenController extends Controller
{
    public function index()
    {
        $type_menu = 'setting';
        $tingkat_resident = TingkatResiden::all();
        return view("page.tingkat-residen.index", [
            'type_menu' => $type_menu,
            'residen' => $tingkat_resident,
        ]);
    }
    public function create()
    {
        $type_menu = 'setting';
        $warna = [
            'Merah',
            'Hijau',
            'Kuning',
            'Biru',
            'Putih',
            'Ungu',
        ];
        return view('page.tingkat-residen.create', [
            'type_menu' => $type_menu,
            'warna' => $warna,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'kd' => 'required|unique:m_tingkat,kd',
            ]
        );

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;
            
            TingkatResiden::create($inputData);

            return redirect()->route('tingkat.residen.index')
                ->with('success', __('message.success_residen_added'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
    public function edit($id)
    {
        return view('page.tingkat-residen.edit', [
            'type_menu' => 'setting',
            'residen' => TingkatResiden::findOrFail($id),
            'warna' => [
                'Merah',
                'Hijau',
                'Kuning',
                'Biru',
                'Putih',
                'Ungu',
            ],
        ]);
    }
    public function update(Request $request, $id)
    {
        $residen = TingkatResiden::findOrFail($id);

        $request->validate([
            'kd' => 'required|unique:m_tingkat,kd,' . $residen->kd . ',kd',
        ]);

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $residen->update($inputData);

            return redirect()->route('tingkat.residen.index')
                ->with('success', __('message.success_residen_edit'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $tingkat_residen = TingkatResiden::findOrFail($id);

            if ($tingkat_residen->residen()->exists()) {
                return back()
                    ->with('warning', 'Tingkat residen tidak bisa dihapus karena masih digunakan.');
            }

            $tingkat_residen->residen()->delete();

            $tingkat_residen->delete();

            return redirect()->route('tingkat.residen.index')
                ->with('success', __('message.success_residen_hapus'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
