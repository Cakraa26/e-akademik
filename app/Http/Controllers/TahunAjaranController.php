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
        ]);

        try {
            $TahunData = $request->all();
            $TahunData['aktif'] = $request->has('aktif') ? 1 : 0;

            TahunAjaran::create([
                'nm' => $TahunData['nm'],
                'aktif' => $TahunData['aktif']
            ]);
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
            'nm' => 'required|unique:m_thnajaran,nm,' . $pk . ',pk'
        ]);

        try {
            $TahunData = $request->all();
            $TahunData['aktif'] = $request->has('aktif') ? 1 : 0;

            $thn->update([
                'nm' => $TahunData['nm'],
                'aktif' => $TahunData['aktif']
            ]);

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
                    ->with('warning', 'Peringatan! Tahun Ajaran tidak dapat dihapus karena masih digunakan');
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
