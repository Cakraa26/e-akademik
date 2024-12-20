<?php

use App\Http\Controllers\API\Resident\AcademicController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MasterDataController;
use App\Http\Controllers\API\Resident\AttendanceController;
use App\Http\Controllers\API\Resident\FormulirController;
use App\Http\Controllers\API\Resident\HomeController;
use App\Http\Controllers\API\Resident\NotificationController;
use App\Http\Controllers\API\Resident\ProfileController;
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
Route::delete('/register/{pk}', [AuthController::class, 'removeRegisterNotVerified']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // residen routes
    Route::middleware('abilities:2')->group(function () {
        Route::get('/home', [HomeController::class, 'index']);

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

        // formulir routes
        Route::get('/formulir', [FormulirController::class, 'getData']);

        // profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'getBiodata']);
            Route::patch('/change-password', [ProfileController::class, 'changePassword']);
            Route::put('/update-biodata', [ProfileController::class, 'updateBiodata']);
        });

        Route::get('/notifications', [NotificationController::class, 'getNotification']);
        Route::put('/notifications/{id}/read', [NotificationController::class, 'readNotification']);
        Route::put('/notifications/{id}/remove', [NotificationController::class, 'removeNotification']);
        Route::get('/announcements', [NotificationController::class, 'getAnnouncement']);
        Route::get('/announcements/{id}', [NotificationController::class, 'getAnnouncementDetail']);
    });

    // Master Data
    Route::get("/motorik-kategori", [MasterDataController::class, 'getMotorikKategori']);
    Route::get("/motorik-subkategori", [MasterDataController::class, 'getMotorikSubKategori']);
    Route::get("/tahun-ajaran", [MasterDataController::class, 'getTahunAjaran']);
    Route::get("/setting", [MasterDataController::class, 'getSetting']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::patch('/register-face', [ProfileController::class, 'registerFace']);
    Route::patch('/register-notif-token', [ProfileController::class, 'registerNotifToken']);
});

