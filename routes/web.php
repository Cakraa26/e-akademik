<?php

use App\Http\Controllers\Dosen;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Mahasiswa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Data Dosen
Route::resource('data-dosen', Dosen::class)->names([
    'index' => 'data.dosen.index',
    'create' => 'data.dosen.create',
    'store' => 'data.dosen.store',
    'edit' => 'data.dosen.edit',
    'update' => 'data.dosen.update',
    'destroy' => 'data.dosen.destroy',
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

// auth
Route::get('/auth-forgot-password', function () {
    return view('pages.auth-forgot-password', ['type_menu' => 'auth']);
});
Route::get('/auth-login', function () {
    return view('pages.auth-login', ['type_menu' => 'auth']);
});

//Register
Route::get('/auth-register', function () {
    return view('pages.auth-register', ['type_menu' => 'auth']);
})->name('auth.register');
Route::post('register/action', [AuthController::class, 'actionRegister'])->name('actionRegister');

Route::get('/auth-reset-password', function () {
    return view('pages.auth-reset-password', ['type_menu' => 'auth']);
});

