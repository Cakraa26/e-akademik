<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function index()
    {
        $type_menu = 'master-data';
        $dosen = Dosen::all();
        return view("page.data-dosen.index", [
            'dosen' => $dosen,
            'type_menu' => $type_menu,
        ]);
    }
    public function create()
    {
        $type_menu = 'master-data';
        return view("page.data-dosen.create", ['type_menu' => $type_menu]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tlp' => 'required|unique:m_dosen,tlp',
            'nip' => 'required|unique:m_dosen,nip',
        ]);

        try {
            $inputData = $request->all();
            $inputData['addedbyfk'] = '0';
            $inputData['lastuserfk'] = '0';
            $inputData['nmuser'] = $inputData['tlp'];
            $inputData['pass'] = Hash::make($inputData['pass']);

            Dosen::create($inputData);

            return redirect()
                ->route('data.dosen.index')
                ->with('success', __('message.success_dosen_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $type_menu = 'master-data';
        $dosen = Dosen::findOrFail($pk);

        return view('page.data-dosen.edit', [
            'dosen' => $dosen,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $dosen = Dosen::findOrFail($pk);

        $request->validate([
            'tlp' => 'required|unique:m_dosen,tlp,' . $dosen->pk . ',pk',
            'nip' => 'required|unique:m_dosen,nip,' . $dosen->pk . ',pk',
        ]);

        try {
            $inputData = $request->all();
            $inputData['nmuser'] = $inputData['tlp'];

            $dosen->update($inputData);

            return redirect()
                ->route('data.dosen.index')
                ->with('success', __('message.success_dosen_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $dosen = Dosen::findOrFail($pk);
            $dosen->delete();

            return redirect()
                ->route('data.dosen.index')
                ->with('success', __('message.success_dosen_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
