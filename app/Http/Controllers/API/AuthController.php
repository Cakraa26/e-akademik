<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Services\Auth\Register\RegisterService;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            $isVerify = $this->registerService->verifyOTP($verifyRequest, $pk);

            if ($isVerify) {
                return response()->json(['message' => 'Verify otp successfully', 'is_verified' => $isVerify]);
            } else {
                return response()->json(['message' => 'Verify otp failed', 'is_verified' => $isVerify], 400);
            }
        } catch (\Throwable $e) {
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

    public function login(LoginRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $user = User::where('username', $username)
                ->first();

            if (!$user && $user->role != 1 && !Hash::check($password, $user->password)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $token = $user->createToken(str()->random(40) . $username, [$user->role])->plainTextToken;

            Auth::setUser($user);

            return response()->json([
                'user' => auth()->user(),
                'token' => $token,
                'role' => $user->role
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
