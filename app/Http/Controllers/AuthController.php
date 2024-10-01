<?php

namespace App\Http\Controllers;

use App\Models\Residen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\Register\RegisterService;

class AuthController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }
    public function actionRegister(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $residen = $this->registerService->register($request);

            DB::commit();
            return redirect()
                ->route('otp.verify', ['residen' => $residen->pk])
                ->with('success', 'Anda berhasil mendaftar. Mohon melakukan verifikasi.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function otp($pk)
    {
        return view('pages.otp', ['pk' => $pk]);
    }
    public function verifyOtp(Request $request, $pk)
    {
        $request->validate([
            'otp' => 'required|array|size:6',
        ]);

        $residen = Residen::findOrFail($pk);

        $inputOtp = implode('', $request->otp);

        if ($residen->otp == $inputOtp && (time() - $residen->waktu <= 300)) {
            $residen->update([
                'is_verified' => 1,
            ]);

            return redirect()->route('auth.login')->with('success', 'Nomor Telepon berhasil diverifikasi!');
        } else {
            return back()->withErrors(['otp' => 'OTP tidak valid atau kadaluwarsa.']);
        }
    }
}
