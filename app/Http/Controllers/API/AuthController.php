<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Services\Auth\Register\RegisterService;
use DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function actionRegister(RegisterRequest $registerRequest)
    {
        try {
           DB::beginTransaction();

            $data = $this->registerService->register($registerRequest);

            DB::commit();
            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function verifyOtp(VerifyRequest $verifyRequest, $pk)
    {
        try {
            DB::beginTransaction();

            $isVerify = $this->registerService->verifyOTP($verifyRequest, $pk);

            if($isVerify) { 
                return response()->json(['message' => 'Verify otp successfully', 'is_verified' => $isVerify]);
            } else {
                return response()->json(['message' => 'Verify otp failed', 'is_verified' => $isVerify], 400); 
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function resendOTP($pk)
    {
        try {
            DB::beginTransaction();

            $resendOTP = $this->registerService->resendOTP($pk);

            DB::commit();
            return response()->json(['data' => $resendOTP], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
