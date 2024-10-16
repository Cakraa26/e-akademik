<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Mahasiswa;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StaseController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\PsikomotorikController;
use App\Http\Controllers\TingkatResidenController;
use App\Http\Controllers\TahunAjaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::redirect('/', '/dashboard-general-dashboard');

// Dashboard
Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

Route::get('/locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

// Data Dosen
Route::resource('data-dosen', DosenController::class)->names([
    'index' => 'data.dosen.index',
    'create' => 'data.dosen.create',
    'store' => 'data.dosen.store',
    'edit' => 'data.dosen.edit',
    'update' => 'data.dosen.update',
    'destroy' => 'data.dosen.destroy',
]);

// Data State
Route::resource('data-stase', StaseController::class)->names([
    'index' => 'data.stase.index',
    'create' => 'data.stase.create',
    'store' => 'data.stase.store',
    'edit' => 'data.stase.edit',
    'update' => 'data.stase.update',
    'destroy' => 'data.stase.destroy',
]);

// Data Mahasiswa
Route::resource('data-mahasiswa', Mahasiswa::class)->names([
    'index' => 'data.mahasiswa.index',
    'create' => 'data.mahasiswa.create',
    'store' => 'data.mahasiswa.store',
    'edit' => 'data.mahasiswa.edit',
    'update' => 'data.mahasiswa.update',
    'destroy' => 'data.mahasiswa.destroy',
]);

// Data Psikomotorik
Route::resource('data-psikomotorik', PsikomotorikController::class)->names([
    'index' => 'data.psikomotorik.index',
    'create' => 'data.psikomotorik.create',
    'store' => 'data.psikomotorik.store',
    'edit' => 'data.psikomotorik.edit',
    'update' => 'data.psikomotorik.update',
    'destroy' => 'data.psikomotorik.destroy',
]);

// Data Group
Route::resource('data-group', GroupController::class)->names([
    'index' => 'data.group.index',
    'create' => 'data.group.create',
    'store' => 'data.group.store',
    'edit' => 'data.group.edit',
    'update' => 'data.group.update',
    'destroy' => 'data.group.destroy',
]);

// Data Kategori
Route::resource('kategori-psikomotorik', KategoriController::class)->names([
    'index' => 'kategori.psikomotorik.index',
    'create' => 'kategori.psikomotorik.create',
    'store' => 'kategori.psikomotorik.store',
    'edit' => 'kategori.psikomotorik.edit',
    'update' => 'kategori.psikomotorik.update',
    'destroy' => 'kategori.psikomotorik.destroy',
]);

// Data Sub Kategori
Route::resource('subkategori-psikomotorik', SubKategoriController::class)->names([
    'index' => 'subkategori.motorik.index',
    'create' => 'subkategori.motorik.create',
    'store' => 'subkategori.motorik.store',
    'edit' => 'subkategori.motorik.edit',
    'update' => 'subkategori.motorik.update',
    'destroy' => 'subkategori.motorik.destroy',
]);

// Data Tingkat Residen
Route::resource('tingkat-residen', TingkatResidenController::class)->names([
    'index' => 'tingkat.residen.index',
    'create' => 'tingkat.residen.create',
    'store' => 'tingkat.residen.store',
    'edit' => 'tingkat.residen.edit',
    'update' => 'tingkat.residen.update',
    'destroy' => 'tingkat.residen.destroy',
]);

// Data Tahun Ajaran
Route::resource('tahun-ajaran', TahunAjaranController::class)->names([
    'index' => 'tahun-ajaran.index',
    'create' => 'tahun-ajaran.create',
    'store' => 'tahun-ajaran.store',
    'edit' => 'tahun-ajaran.edit',
    'update' => 'tahun-ajaran.update',
    'destroy' => 'tahun-ajaran.destroy',
]);

// auth
Route::get('/auth-forgot-password', function () {
    return view('pages.auth-forgot-password', ['type_menu' => 'auth']);
});
Route::get('/auth-login', function () {
    return view('pages.auth-login', ['type_menu' => 'auth']);
})->name('auth.login');

//Register
Route::get('/auth-register', function () {
    return view('pages.auth-register', ['type_menu' => 'auth']);
})->name('auth.register');
Route::post('register/action', [AuthController::class, 'actionRegister'])->name('actionRegister');
Route::get('/otp/verify/{residen}', [AuthController::class, 'otp'])->name('otp.verify');
Route::post('/otp-register', [AuthController::class, 'otp']);
Route::post('/otp/verify/{residen}', [AuthController::class, 'verifyOtp'])->name('otp.verify.post');
Route::post('/otp/resend/{pk}', [AuthController::class, 'resendOTP'])->name('otp.resend');

Route::get('/auth-reset-password', function () {
    return view('pages.auth-reset-password', ['type_menu' => 'auth']);
});



