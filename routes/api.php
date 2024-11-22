<?php

use App\Http\Controllers\API\Resident\AcademicController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MasterDataController;
use App\Http\Controllers\API\Resident\AttendanceController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // residen routes
    Route::middleware('abilities:2')->group(function () {

        // academic routes
        Route::prefix("academic")->group(function () {
            Route::prefix('karya-ilmiah')->group(function () {
                Route::get("/residen/{residenId}", [AcademicController::class, 'getKaryaIlimiahByResiden']);
                Route::put("/{karyaIlmiahId}/residen/{residenId}/upload", [AcademicController::class, 'residenUploadKaryaIlmiah']);
            });

            Route::prefix('psikomotorik')->group(function () {
                Route::get('', [AcademicController::class, 'getPsikomotorikByResiden']);
                Route::get('/{motorikTransactionId}', [AcademicController::class, 'getPsikomotorikDetailByResiden']);
                Route::post('/{motorikId}/upload', [AcademicController::class, 'uploadPsikomotorikByResiden']);
                Route::patch('/{motorikId}/upload/{motorikTransactionDataId}', [AcademicController::class, 'updateUploadPsikomotorikByResiden']);
                Route::delete('/{motorikId}/upload/{motorikTransactionDataId}', [AcademicController::class, 'deleteUploadPsikomotorikByResiden']);
            });

            Route::prefix('kognitif')->group(function () {
                Route::get('/stase', [AcademicController::class, 'getNilaiStaseResiden']);
                Route::put('/stase/{staseJadwalNilaiId}/upload', [AcademicController::class, 'uploadStaseResiden']);
                Route::get('/uts', [AcademicController::class, 'getNilaiUTSResiden']);
                Route::get('/uas', [AcademicController::class, 'getNilaiUASResiden']);
            });

            Route::get('/afektif', [AttendanceController::class, 'getAfektif']);
        });

        // attendance routes
        Route::prefix("attendance")->group(function () {
            Route::get('/state', [AttendanceController::class, 'getAttendanceState']);
            Route::post('/check-in', [AttendanceController::class, 'checkIn']);
            Route::post('/check-out', [AttendanceController::class, 'checkOut']);
        });
    });

    // Master Data
    Route::get("/motorik-kategori", [MasterDataController::class, 'getMotorikKategori']);
    Route::get("/motorik-subkategori", [MasterDataController::class, 'getMotorikSubKategori']);
    Route::get("/tahun-ajaran", [MasterDataController::class, 'getTahunAjaran']);
    Route::get("/setting", [MasterDataController::class, 'getSetting']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

