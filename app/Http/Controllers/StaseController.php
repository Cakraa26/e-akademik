<?php

namespace App\Http\Controllers;

use App\Models\Stase;
use Illuminate\Http\Request;

class StaseController extends Controller
{
    public function index()
    {
        $stase = Stase::all();
        return view("page.data-stase.index", ['stase' => $stase,]);
    }
    public function create()
    {
        return view("page.data-stase.create");
    }
    public function store(Request $request)
    {
        try {
            $inputData = $request->all();
            $inputData['addedbyfk'] = '0';
            $inputData['lastuserfk'] = '0';

            Stase::create($inputData);

            return redirect()
                ->route('data.stase.index')
                ->with('success', 'Data Stase berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $stase = Stase::findOrFail($pk);

        return view('page.data-stase.edit', [
            'stase' => $stase
        ]);
    }
    public function update(Request $request, $pk)
    {
        try {
            $stase = Stase::findOrFail($pk);
            $stase->update($request->all());

            return redirect()
                ->route('data.stase.index')
                ->with('success', 'Data Stase berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $stase = Stase::findOrFail($pk);
            $stase->delete();

            return redirect()
                ->route('data.stase.index')
                ->with('success', 'Data Stase berhasil dihapus.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
