<?php

namespace App\Http\Controllers;

use App\Models\GroupMotorik;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $type_menu = 'psikomotorik';
        $group = GroupMotorik::all();
        return view("page.data-group.index", [
            'group' => $group,
            'type_menu' => $type_menu,
        ]);
    }
    public function create()
    {
        $type_menu = 'psikomotorik';
        return view("page.data-group.create", [
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            GroupMotorik::create($inputData);

            if ($request->redirect == 'psikomotorik') {
                return back()->with('success', __('message.success_group_added'));
            } else {
                return redirect()->route('data.group.index')->with('success', __('message.success_group_added'));
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
        $group = GroupMotorik::findOrFail($pk);
        return view("page.data-group.edit", [
            'type_menu' => $type_menu,
            'group' => $group,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $group = GroupMotorik::findOrFail($pk);

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $group->update($inputData);

            return redirect()
                ->route('data.group.index')
                ->with('success', __('message.success_group_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $group = GroupMotorik::findOrFail($pk);
            $group->delete();

            return redirect()
                ->route('data.group.index')
                ->with('success', __('message.success_group_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
