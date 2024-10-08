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
            'tlp.unique' => __('message.tlpunique'),
            'nip.unique' => __('message.nipunique'),
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
            'tlp.unique' => __('message.tlpunique'),
            'nip.unique' => __('message.nipunique'),
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
