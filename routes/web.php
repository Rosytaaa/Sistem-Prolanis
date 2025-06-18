<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\HasillabController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ManajemenUserController;


Route::get('/',[SesiController::class,'index']);

Route::post('/',[SesiController::class,'login']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::resource('menupasien', PasienController::class);

Route::get('/createpasien', function(){
    return view('createpasien');
});

Route::get('/hasillab', [HasilLabController::class, 'index']);
Route::post('/hasillab', [HasilLabController::class, 'store'])->name('hasillab.store');


Route::get('/jadwalkunjungan', function(){
    return view('jadwalkunjungan');
});
Route::put('/menupasien/{$data}', [PasienController::class, 'update'])->name('menupasien.update');
Route::post('/import-pasien', [PasienController::class, 'import'])->name('pasien.import');
Route::post('/import-hasillab', [HasillabController::class, 'import'])->name('hasillab.import');
Route::resource('hasillab', HasillabController::class);

Route::get('/createhasillab', [HasillabController::class, 'create'])->name('/createhasillab');
Route::resource('jadwalkunjungan', JadwalController::class);
Route::get('/pasien/diabetes', [PasienController::class, 'diabetes'])->name('pasien.diabetes');
Route::get('/pasien/hipertensi', [PasienController::class, 'hipertensi'])->name('pasien.hipertensi');
Route::get('/pasien/diabetesdanhipertensi', [PasienController::class, 'keduanya'])->name('pasien.keduanya');

Route::get('/export-pasien', [PasienController::class, 'export'])
    ->middleware(RoleMiddleware::class . ':operator,dokter,pimpinan');

Route::get('/export-hasillab', [HasillabController::class, 'export'])
    ->middleware(RoleMiddleware::class . ':operator,dokter,pimpinan');

Route::middleware([RoleMiddleware::class . ':operator'])->group(function () {
    Route::resource('/manajemenuser', ManajemenUserController::class)->only(['index', 'edit', 'update']);
});


