<?php

namespace App\Http\Controllers;

use App\Models\Stase;
use Illuminate\Http\Request;

class StaseController extends Controller
{
    public function index()
    {
        $type_menu = 'master-data';
        $stase = Stase::all();
        return view("page.data-stase.index", [
            'stase' => $stase,
            'type_menu' => $type_menu,
        ]);
    }
    public function create()
    {
        $type_menu = 'master-data';
        return view("page.data-stase.create", [
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nm' => 'required|unique:m_stase,nm',
        ]);

        try {
            $inputData = $request->all();
            $inputData['addedbyfk'] = '0';
            $inputData['lastuserfk'] = '0';

            Stase::create($inputData);

            return redirect()
                ->route('data.stase.index')
                ->with('success', __('message.success_stase_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $type_menu = 'master-data';
        $stase = Stase::findOrFail($pk);

        return view('page.data-stase.edit', [
            'stase' => $stase,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $request->validate([
            'nm' => 'required|unique:m_stase,nm,' . $pk . ',pk',
        ]);

        try {
            $stase = Stase::findOrFail($pk);
            $stase->update($request->all());

            return redirect()
                ->route('data.stase.index')
                ->with('success', __('message.success_stase_edit'));
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
                ->with('success', __('message.success_stase_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
