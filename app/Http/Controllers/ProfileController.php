<?php

namespace App\Http\Controllers;

use App\Models\Residen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $type_menu = 'profile';
        $residen = Residen::where('pk', auth()->user()->pk)->first();
        return view('residen.profile.index', [
            'type_menu' => $type_menu,
            'residen' => $residen
        ]);
    }
    public function update(Request $request, $pk)
    {
        $residen = Residen::findOrFail($pk);

        $request->validate([
            'nim' => 'required|unique:m_residen,nim,' . $residen->pk . ',pk',
            'inisialresiden' => 'required|unique:m_residen,inisialresiden,' . $residen->pk . ',pk',
            'ktp' => 'required|unique:m_residen,ktp,' . $residen->pk . ',pk',
            'hp' => 'required|unique:m_residen,hp,' . $residen->pk . ',pk',
        ]);

        try {
            $inputData = $request->all();

            $residen->update($inputData);

            return redirect()
                ->route('profile')
                ->with('success', __('message.success_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function editPassword()
    {
        $type_menu = 'profile';
        return view('residen.profile.editpassword', [
            'type_menu' => $type_menu,
        ]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'password' => 'different:new_password',
            ],
            [
                'new_password.different' => 'Password baru tidak boleh sama dengan password lama.',
            ]
        );

        try {
            $residenfk = auth()->user()->pk;
            $residen = Residen::findOrFail($residenfk);

            $residen->update([
                'password' => Hash::make($request->input('new_password'))
            ]);

            return redirect()
                ->route('dashboard')
                ->with('success', __('message.success_password_edit')); 
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
