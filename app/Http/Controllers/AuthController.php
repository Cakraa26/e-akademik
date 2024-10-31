<?php

namespace App\Http\Controllers;

use App\Models\Residen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\VerifyRequest;
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
    public function verifyOtp(VerifyRequest $request, $pk)
    {
        try {
            DB::beginTransaction();

            $isVerified = $this->registerService->verifyOTP($request, $pk);

            DB::commit();
            if ($isVerified) {
                return redirect()->route('auth.login')->with('success', 'Nomor Telepon berhasil diverifikasi.');
            } else {
                return back()->withErrors(['otp' => 'OTP tidak valid atau kadaluwarsa.']);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function resendOTP($pk)
    {
        try {
            DB::beginTransaction();

            $resendOTP = $this->registerService->resendOTP($pk);

            DB::commit();
            return redirect()
                ->route('otp.verify', ['residen' => $resendOTP->pk])
                ->with('success', 'Kode OTP baru telah dikirim.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::table('account')
            ->where('username', $username)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            if ($user->is_verified == 1) {
                Session::put('nm', $user->nm);
                Session::put('semester', $user->semester);
                Session::put('tingkat', $user->tingkat->kd);

                Session::put('role', $user->role);
                return redirect()
                    ->route('dashboard');
            } else {
                return back()->with('gagal', __('message.error_not_verified'));
            }
        }

        return back()->with('error', __('message.error_username'));
    }
    public function logout()
    {
        Session::flush();
        return redirect('/')->with('success', __('message.success_logout'));
    }
}
