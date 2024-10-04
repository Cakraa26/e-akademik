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
        $dosen = Dosen::all();
        return view("page.data-dosen.index", ['dosen' => $dosen,]);
    }
    public function create()
    {
        return view("page.data-dosen.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'tlp' => 'required|unique:m_dosen,tlp',
            'nip' => 'required|unique:m_dosen,nip',
        ], [
            'tlp.unique' => 'No. Telepon sudah terdaftar.',
            'nip.unique' => 'NIP sudah terdaftar.',
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
                ->with('success', 'Data Dosen berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $dosen = Dosen::findOrFail($pk);

        return view('page.data-dosen.edit', [
            'dosen' => $dosen
        ]);
    }
    public function update(Request $request, $pk)
    {
        $dosen = Dosen::findOrFail($pk);

        $request->validate([
            'tlp' => [
                'required',
                Rule::unique('m_dosen', 'tlp')->ignore($dosen->pk, 'pk'),
            ],
            'nip' => [
                'required',
                Rule::unique('m_dosen', 'nip')->ignore($dosen->pk, 'pk'),
            ],
        ], [
            'tlp.unique' => 'No. Telepon sudah terdaftar.',
            'nip.unique' => 'NIP sudah terdaftar.',
        ]);


        try {
            $inputData = $request->all();
            $inputData['nmuser'] = $inputData['tlp'];

            $dosen->update($inputData);

            return redirect()
                ->route('data.dosen.index')
                ->with('success', 'Data Dosen berhasil diperbarui');
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
                ->with('success', 'Data Dosen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
