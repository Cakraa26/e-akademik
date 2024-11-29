<?php

use App\Http\Controllers\Absensi;
use App\Models\MotorikTransaction;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\NilaiStase;
use App\Http\Controllers\JadwalStase;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarAbsensi;
use App\Http\Controllers\UASController;
use App\Http\Controllers\UTSController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NilaiStaseResiden;
use App\Http\Controllers\StaseController;
use App\Http\Controllers\HistoriKehadiran;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryaIlmiahResiden;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\HariKerjaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PsikomotorikResiden;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\KaryaIlmiahController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\PsikomotorikController;
use App\Http\Controllers\KaryaIlmiahResidenAdmin;
use App\Http\Controllers\TingkatResidenController;
use App\Http\Controllers\DatabaseResidenController;
use App\Http\Controllers\KognitifResiden;

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

Route::get('/', function () {
    return view('pages.auth-login', ['type_menu' => 'auth']);
})->name('login');

Route::post('/login/post', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

Route::get('/locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

// Dashboard
Route::get('/dashboard', function () {
    return view('pages.dashboard-general-dashboard', ['type_menu' => 'dashboard']);
})->middleware('checkRole:0,1,2')->name('dashboard');

// Route::middleware(['checkRole:0'])->group(function () {

// });

Route::middleware(['checkRole:1'])->group(function () {
    // Data Dosen
    Route::resource('data-dosen', DosenController::class)->names([
        'index' => 'data.dosen.index',
        'create' => 'data.dosen.create',
        'store' => 'data.dosen.store',
        'edit' => 'data.dosen.edit',
        'update' => 'data.dosen.update',
        'destroy' => 'data.dosen.destroy',
    ]);

    // Data Calon Residen
    Route::resource('data-mahasiswa', MahasiswaController::class)->names([
        'index' => 'data.mahasiswa.index',
        'create' => 'data.mahasiswa.create',
        'store' => 'data.mahasiswa.store',
        'edit' => 'data.mahasiswa.edit',
        'update' => 'data.mahasiswa.update',
        'destroy' => 'data.mahasiswa.destroy',
        'show' => 'data.mahasiswa.show',
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

    // Data Kelas
    Route::resource('data-kelas', KelasController::class)->names([
        'index' => 'data.kelas.index',
        'create' => 'data.kelas.create',
        'store' => 'data.kelas.store',
        'edit' => 'data.kelas.edit',
        'update' => 'data.kelas.update',
        'destroy' => 'data.kelas.destroy',
    ]);

    // Jadwal Stase
    Route::resource('jadwal-stase', JadwalStase::class)->names([
        'index' => 'jadwal.stase.index',
        'create' => 'jadwal.stase.create',
        // 'store' => 'jadwal.stase.store',
        'edit' => 'jadwal.stase.edit',
        'update' => 'jadwal.stase.update',
        'destroy' => 'jadwal.stase.destroy',
    ]);
    Route::post('/jadwal-stase/{pk}/store', [JadwalStase::class, 'store'])->name('jadwal.stase.store');

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

    // Monitoring Psikomotorik
    Route::resource('monitoring-motorik', MonitoringController::class)->names([
        'index' => 'monitoring.index',
        'create' => 'monitoring.create',
        'store' => 'monitoring.store',
        'edit' => 'monitoring.edit',
        'update' => 'monitoring.update',
        'destroy' => 'monitoring.destroy',
    ]);

    Route::get('/monitoring-motorik/{pk}/detail', [MonitoringController::class, 'detail'])->name('monitoring.detail');
    Route::get('/monitoring-motorik/{pk}/{residenfk}/detail/approved', [MonitoringController::class, 'approve'])->name('monitoring.approve');
    Route::post('/monitoring-motorik/{pk}/detail/approved-store', [MonitoringController::class, 'approveStore'])->name('approve.store');

    // Karya Ilmiah Admin
    Route::resource('karya-ilmiah', KaryaIlmiahController::class)->names([
        'index' => 'karya-ilmiah.index',
        'create' => 'karya-ilmiah.create',
        'store' => 'karya-ilmiah.store',
        'edit' => 'karya-ilmiah.edit',
        'update' => 'karya-ilmiah.update',
        'destroy' => 'karya-ilmiah.destroy',
    ]);

    // Karya Ilmiah Residen Admin
    Route::resource('karyailmiah-residen', KaryaIlmiahResidenAdmin::class)->parameters(['karyailmiah-residen' => 'pk'])->names([
        'index' => 'karyailmiahresiden.index',
        'create' => 'karyailmiahresiden.create',
        'store' => 'karyailmiahresiden.store',
        'edit' => 'karyailmiahresiden.edit',
        'update' => 'karyailmiahresiden.update',
        'destroy' => 'karyailmiahresiden.destroy',
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

    // Data Tingkat Residen
    Route::resource('tingkat-residen', TingkatResidenController::class)->names([
        'index' => 'tingkat.residen.index',
        'create' => 'tingkat.residen.create',
        'store' => 'tingkat.residen.store',
        'edit' => 'tingkat.residen.edit',
        'update' => 'tingkat.residen.update',
        'destroy' => 'tingkat.residen.destroy',
    ]);

    // Nilai Stase
    Route::resource('nilai-stase', NilaiStase::class)->names([
        'index' => 'nilai.stase.index',
        'create' => 'nilai.stase.create',
        'store' => 'nilai.stase.store',
        'edit' => 'nilai.stase.edit',
        'update' => 'nilai.stase.update',
        'destroy' => 'nilai.stase.destroy',
    ]);

    // UAS
    Route::resource('uas', UASController::class)->names([
        'index' => 'uas.index',
        'edit' => 'uas.edit',
        'update' => 'uas.update',
    ]);

    // UTS
    Route::resource('uts', UTSController::class)->names([
        'index' => 'uts.index',
        'edit' => 'uts.edit',
        'update' => 'uts.update',
    ]);

    // Upload File
    Route::resource('upload-file', UploadFileController::class)->names([
        'index' => 'upload.file.index',
        'create' => 'upload.file.create',
        'store' => 'upload.file.store',
        'show' => 'upload.file.show',
        'edit' => 'upload.file.edit',
        'update' => 'upload.file.update',
        'destroy' => 'upload.file.destroy',
    ]);

    // Database Residen
    Route::resource('database-residen', DatabaseResidenController::class)->names([
        'index' => 'database.residen.index',
        'create' => 'database.residen.create',
        'store' => 'database.residen.store',
        'edit' => 'database.residen.edit',
        'update' => 'database.residen.update',
        'destroy' => 'database.residen.destroy',
    ]);

    // Pengumuman
    Route::resource('pengumuman', PengumumanController::class)->names([
        'index' => 'pengumuman.index',
        'create' => 'pengumuman.create',
        'store' => 'pengumuman.store',
        'edit' => 'pengumuman.edit',
        'update' => 'pengumuman.update',
        'destroy' => 'pengumuman.destroy',
    ]);

    // Data Hari Kerja
    Route::resource('hari-kerja', HariKerjaController::class)->names([
        'index' => 'hari.kerja.index',
        'create' => 'hari.kerja.create',
        'store' => 'hari.kerja.store',
        'edit' => 'hari.kerja.edit',
        'update' => 'hari.kerja.update',
        'destroy' => 'hari.kerja.destroy',
    ]);

    // Absensi
    Route::resource('absensi', Absensi::class)->names([
        'index' => 'absensi.index',
        'create' => 'absensi.create',
        'store' => 'absensi.store',
        'edit' => 'absensi.edit',
        'update' => 'absensi.update',
        'destroy' => 'absensi.destroy',
    ]);

    // Daftar Absensi
    Route::resource('daftar-absensi', DaftarAbsensi::class)->names([
        'index' => 'daftar.absensi.index',
        'update' => 'daftar.absensi.update',
        'destroy' => 'daftar.absensi.destroy',
    ]);
    Route::get('/daftar-absensi/{pk}/{bulan}/detail', [DaftarAbsensi::class, 'detail'])->name('daftar.absensi.detail');

});

Route::middleware(['checkRole:2'])->group(function () {
    // Karya Ilmiah 
    Route::resource('karya-ilmiah-residen', KaryaIlmiahResiden::class)->names([
        'index' => 'karya-ilmiah.residen.index',
        'store' => 'karya-ilmiah.upload',
    ]);

    // Psikomotorik
    Route::resource('psikomotorik', PsikomotorikResiden::class)->names([
        'index' => 'psikomotorik.index',
        'store' => 'psikomotorik.upload',
        'edit' => 'psikomotorik.edit',
        'destroy' => 'psikomotorik.destroy',
    ]);
    Route::post('/psikomotorik/upload-detail', [PsikomotorikResiden::class, 'uploadDetail'])->name('psikomotorik.upload.detail');

    // Edit Profile
    Route::resource('profile', ProfileController::class)->names([
        'index' => 'profile',
        'update' => 'profile.update',
    ]);
    Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('edit.password');
    Route::post('/reset-password', [ProfileController::class, 'resetPassword'])->name('reset-password');

    // Afektif
    Route::resource('histori-kehadiran', HistoriKehadiran::class)->names([
        'index' => 'histori.kehadiran.index',
    ]);

    // Kognitif
    Route::resource('nilai-stase-residen', NilaiStaseResiden::class)->names([
        'index' => 'nilai.stase.residen.index',
        'store' => 'nilai.stase.residen.upload',
    ]);
    Route::get('/uts-residen', [KognitifResiden::class, 'utsIndex'])->name('uts.residen.index');
    Route::get('/uas-residen', [KognitifResiden::class, 'uasIndex'])->name('uas.residen.index');

    Route::get('/download-file-residen', [UploadFileController::class, 'indexResiden'])->name('download.file.index');
});

// auth
Route::get('/auth-forgot-password', function () {
    return view('pages.auth-forgot-password', ['type_menu' => 'auth']);
});
