<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $type_menu = 'psikomotorik';
        $ktgmotorik = Kategori::all();
        return view("page.kategori-psikomotorik.index", [
            'ktgmotorik' => $ktgmotorik,
            'type_menu' => $type_menu,
        ]);
    }
    public function create()
    {
        $type_menu = 'psikomotorik';
        return view("page.kategori-psikomotorik.create", [
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $ktgmotorik = Kategori::create($inputData);

            if ($request->redirect == 'psikomotorik') {
                return back()->with('success', __('message.success_kategori_added'));
            } else {
                return redirect()->route('kategori.psikomotorik.index')->with('success', __('message.success_kategori_added'));
            }
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $type_menu = 'psikomotorik';
        $ktgmotorik = Kategori::findOrFail($pk);
        return view("page.kategori-psikomotorik.edit", [
            'type_menu' => $type_menu,
            'ktgmotorik' => $ktgmotorik,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $ktgmotorik = Kategori::findOrFail($pk);

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $ktgmotorik->update($inputData);

            return redirect()
                ->route('kategori.psikomotorik.index')
                ->with('success', __('message.success_kategori_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $ktgmotorik = Kategori::findOrFail($pk);
            $ktgmotorik->delete();

            return redirect()
                ->route('kategori.psikomotorik.index')
                ->with('success', __('message.success_kategori_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
