<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    public function index()
    {
        $type_menu = 'psikomotorik';
        $subktgmotorik = SubKategori::all();
        return view("page.subkategori-psikomotorik.index", [
            'subktgmotorik' => $subktgmotorik,
            'type_menu' => $type_menu,
        ]);
    }
    public function create()
    {
        $type_menu = 'psikomotorik';
        return view("page.subkategori-psikomotorik.create", [
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $subktgmotorik = SubKategori::create($inputData);

            if ($request->redirect == 'psikomotorik') {
                return back()->with('success', __('message.success_subkategori_added'));
            } else {
                return redirect()->route('subkategori.motorik.index')->with('success', __('message.success_subkategori_added'));
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
        $subktgmotorik = SubKategori::findOrFail($pk);
        return view("page.subkategori-psikomotorik.edit", [
            'type_menu' => $type_menu,
            'subktgmotorik' => $subktgmotorik,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $subktgmotorik = SubKategori::findOrFail($pk);

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $subktgmotorik->update($inputData);

            return redirect()
                ->route('subkategori.motorik.index')
                ->with('success', __('message.success_subkategori_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $subktgmotorik = SubKategori::findOrFail($pk);
            $subktgmotorik->delete();

            return redirect()
                ->route('subkategori.motorik.index')
                ->with('success', __('message.success_subkategori_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
