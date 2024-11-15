<?php

namespace App\Http\Controllers;

use App\Models\KaryaIlmiah;
use App\Models\KaryaIlmiahData;
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
    public function edit($pk)
    {
        $type_menu = 'karyailmiah';
        $karya = KaryaIlmiah::findOrFail($pk);
        return view("page.karya-ilmiah.edit", [
            'type_menu' => $type_menu,
            'karya' => $karya,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $karya = KaryaIlmiah::findOrFail($pk);

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $karya->update($inputData);

            return redirect()
                ->route('karya-ilmiah.index')
                ->with('success', __('message.success_karyailmiah_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function create()
    {
        $type_menu = 'karyailmiah';
        return view("page.karya-ilmiah.create", [
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            KaryaIlmiah::create($inputData);


            return redirect()->route('karya-ilmiah.index')->with('success', __('message.success_karyailmiah_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $karya = KaryaIlmiah::findOrFail($pk);
            $referensi = KaryaIlmiahData::where('karyailmiahfk', $pk)->exists();
            if ($referensi) {
                return back()
                    ->with('gagal', __('message.success_tahunajaran_warning'));
            }
            $karya->delete();

            return redirect()
                ->route('karya-ilmiah.index')
                ->with('success', __('message.success_karyailmiah_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
