<?php

use App\Http\Controllers\API\AcademicController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'actionRegister']);
Route::post('/register/verify-otp/{pk}', [AuthController::class, 'verifyOtp']);
Route::patch('/register/verify-otp/{pk}/resend', [AuthController::class, 'resendOTP']);

Route::prefix("academic")->group(function () {
    Route::prefix('karya-ilmiah')->group(function () {
        Route::get("/residen/{residenId}", [AcademicController::class, 'getKaryaIlimiahByResiden']);
        Route::put("/{karyaIlmiahId}/residen/{residenId}/upload", [AcademicController::class, 'residenUploadKaryaIlmiah']);
    });
});
