<?php

namespace App\Http\Controllers;

use App\Models\GroupMotorik;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        try {
            $motorik = GroupMotorik::create($request->all());

            return back()->with('success', __('message.success_group_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
