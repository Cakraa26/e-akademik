<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $type_menu = 'setting';
        $thn = TahunAjaran::all();
        return view("page.tahun-ajaran.index", [
            'thn' => $thn,
            'type_menu' => $type_menu,
        ]);

    }
    public function create()
    {
        $type_menu = 'setting';
        return view("page.tahun-ajaran.create", [
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nm' => 'required|unique:m_thnajaran,nm'
        ], [
            'nm' => __('message.nama'),
            'bulan1' => 'required'
        ], [
            'bulan1' => __('message.bulan1'),
            'bulan2' => 'required'
        ], [
            'bulan2' => __('message.bulan2'),
            'bulan3' => 'required'
        ], [
            'bulan3' => __('message.bulan3'),
            'bulan4' => 'required'
        ], [
            'bulan4' => __('message.bulan4'),
            'bulan5' => 'required'
        ], [
            'bulan5' => __('message.bulan5'),
            'bulan6' => 'required'
        ], [
            'bulan6' => __('message.bulan6'),
        ]);

        try {
            $TahunData = $request->all();
            $TahunData['aktif'] = $request->has('aktif') ? 1 : 0;

            TahunAjaran::create($TahunData);
            return redirect()
                ->route('tahun-ajaran.index')
                ->with('success', __('message.success_tahunajaran_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $type_menu = 'setting';
        $thn = TahunAjaran::findOrFail($pk);
        return view("page.tahun-ajaran.edit", [
            'thn' => $thn,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $thn = TahunAjaran::findOrFail($pk);

        $request->validate([
            'nm' => 'required|unique:m_thnajaran,nm,' . $thn->pk . ',pk',
        ]);

        try {
            $TahunData = $request->all();
            $TahunData['aktif'] = $request->has('aktif') ? 1 : 0;

            $thn->update($TahunData);

            return redirect()
                ->route('tahun-ajaran.index')
                ->with('success', __('message.success_tahunajaran_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $TahunData = TahunAjaran::findOrFail($pk);

            if ($TahunData->kelas()->exists()) {
                return back()
                    ->withInput()
                    ->with('warning', __('message.success_tahunajaran_warning'));
            }

            $TahunData->delete();

            return redirect()
                ->route('tahun-ajaran.index')
                ->with('success', __('message.success_tahunajaran_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
