<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Residen;
use App\Services\Auth\Register\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService) 
    {
        $this->registerService = $registerService;
    }
    public function actionRegister(RegisterRequest $request){
        try {
            DB::beginTransaction();
            
            $this->registerService->register($request);

            DB::commit();
            return redirect()
                ->route('auth.register')
                ->with('success', 'Anda berhasil mendaftar.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
