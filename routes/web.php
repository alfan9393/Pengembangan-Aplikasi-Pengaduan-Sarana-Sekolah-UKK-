<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'cekLogin']);
Route::get('/logout',[AuthController::class,'logout']);

Route::get('/register',[AuthController::class,'register']);
Route::post('/register',[AuthController::class,'store']);

Route::get('/admin/dashboard',[PengaduanController::class,'adminDashboard']);
Route::get('/admin/laporan',[PengaduanController::class,'adminLaporan']);

Route::get('/admin/proses/{id}',[PengaduanController::class,'acc']);
Route::get('/admin/selesai/{id}',[PengaduanController::class,'selesai']);

Route::get('/pengaduan',[PengaduanController::class,'index']);
Route::get('/pengaduan/add',[PengaduanController::class,'add']);
Route::post('/pengaduan/store',[PengaduanController::class,'store']);
Route::get('/pengaduan/detail/{id}',[PengaduanController::class,'detail']);
Route::get('/pengaduan/edit/{id}', [PengaduanController::class,'edit']);
Route::post('/pengaduan/update/{id}', [PengaduanController::class,'update']);
Route::get('/pengaduan/delete/{id}', [PengaduanController::class,'delete']);

