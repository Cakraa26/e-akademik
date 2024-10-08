<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\GroupMotorik;
use App\Models\Psikomotorik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PsikomotorikController extends Controller
{
    public function index()
    {
        $motorik = Psikomotorik::all();
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();
        $subkategori = SubKategori::select('pk', 'nm')->get();

        return view("page.data-psikomotorik.index", [
            'motorik' => $motorik,
            'group' => $group,
            'kategori' => $kategori,
            'subkategori' => $subkategori,
        ]);
    }
    public function create()
    {
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();
        $subkategori = SubKategori::select('pk', 'nm')->get();

        return view("page.data-psikomotorik.create", [
            'group' => $group,
            'kategori' => $kategori,
            'subkategori' => $subkategori,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'groupfk' => 'required',
            'kategorifk' => 'required',
            'subkategorifk' => 'required',
        ], [
            'groupfk.required' => __('message.grouprequired'),
            'kategorifk.required' => __('message.kategorifkrequired'),
            'subkategorifk.required' => __('message.subkategorifkrequired'),
        ]);

        try {
            $inputData = $request->all();
            $inputData['addedbyfk'] = '0';
            $inputData['lastuserfk'] = '0';

            Psikomotorik::create($inputData);

            return redirect()
                ->route('data.psikomotorik.index')
                ->with('success', __('message.success_psikomotorik_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $motorik = Psikomotorik::findOrFail($pk);
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();
        $subkategori = SubKategori::select('pk', 'nm')->get();

        return view('page.data-psikomotorik.edit', [
            'motorik' => $motorik,
            'group' => $group,
            'kategori' => $kategori,
            'subkategori' => $subkategori,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $motorik = Psikomotorik::findOrFail($pk);

        $request->validate([
            'groupfk' => 'required',
            'kategorifk' => 'required',
            'subkategorifk' => 'required',
        ], [
            'groupfk.required' => __('message.grouprequired'),
            'kategorifk.required' => __('message.kategorifkrequired'),
            'subkategorifk.required' => __('message.subkategorifkrequired'),
        ]);

        try {
            $inputData = $request->all();

            $motorik->update($inputData);

            return redirect()
                ->route('data.psikomotorik.index')
                ->with('success', __('message.success_psikomotorik_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $motorik = Psikomotorik::findOrFail($pk);
            $motorik->delete();

            return redirect()
                ->route('data.psikomotorik.index')
                ->with('success', __('message.success_psikomotorik_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
