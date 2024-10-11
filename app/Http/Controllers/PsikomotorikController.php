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
    public function index(Request $request)
    {
        $type_menu = 'psikomotorik';

        $query = Psikomotorik::query();

        $query->when(request()->has('groupfk') && request('groupfk') != '', function ($q) {
            return $q->where('groupfk', request('groupfk'));
        });

        $query->when(request()->has('kategorifk') && request('kategorifk') != '', function ($q) {
            return $q->where('kategorifk', request('kategorifk'));
        });

        $motorik = $query->get();

        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();
        $subkategori = SubKategori::select('pk', 'nm')->get();

        return view("page.data-psikomotorik.index", [
            'type_menu' => $type_menu,
            'motorik' => $motorik,
            'group' => $group,
            'kategori' => $kategori,
            'subkategori' => $subkategori,
        ]);
    }
    public function create()
    {
        $type_menu = 'psikomotorik';
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();
        $subkategori = SubKategori::select('pk', 'nm')->get();

        return view("page.data-psikomotorik.create", [
            'type_menu' => $type_menu,
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
        $type_menu = 'psikomotorik';
        $motorik = Psikomotorik::findOrFail($pk);
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();
        $subkategori = SubKategori::select('pk', 'nm')->get();

        return view('page.data-psikomotorik.edit', [
            'type_menu' => $type_menu,
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
