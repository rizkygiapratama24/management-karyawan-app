<?php

use App\Http\Controllers\Api\DataKaryawanController;
use App\Http\Controllers\Api\DataPosisiController;
use App\Http\Controllers\Api\DataTempatController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\RoleBasedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create_posisi', DataPosisiController::class)->name('create_posisi');
    Route::get('/get_posisi/{id}', [DataPosisiController::class, 'get_posisi'])->name('get_posisi');
    Route::get('/data_posisi', [DataPosisiController::class, 'data_posisi'])->name('data_posisi');
    Route::post('/update_posisi/{id}', [DataPosisiController::class, 'update_posisi'])->name('update_posisi');
    Route::get('/delete_posisi/{id}', [DataPosisiController::class, 'delete_posisi'])->name('delete_posisi');

    Route::post('/create_tempat', DataTempatController::class)->name('create_tempat');
    Route::get('/get_tempat/{id}', [DataTempatController::class, 'get_tempat'])->name('get_tempat');
    Route::post('/update_tempat/{id}', [DataTempatController::class, 'update_tempat'])->name('update_tempat');
    Route::get('/delete_tempat/{id}', [DataTempatController::class, 'delete_tempat'])->name('delete_tempat');

    Route::post('/create_role', RoleBasedController::class)->name('create_role');
    Route::get('/get_role/{id}', [RoleBasedController::class, 'get_role'])->name('get_role');
    Route::post('/update_role/{id}', [RoleBasedController::class, 'update_role'])->name('update_role');
    Route::get('/delete_role/{id}', [RoleBasedController::class, 'delete_role'])->name('delete_role');

    Route::post('/create_karyawan', DataKaryawanController::class)->name('create_karyawan');
    Route::get('/get_karyawan/{id}', [DataKaryawanController::class, 'get_karyawan'])->name('get_karyawan');
    Route::post('/update_karyawan/{id}', [DataKaryawanController::class, 'update_karyawan'])->name('update_karyawan');
    Route::get('/delete_karyawan/{id}', [DataKaryawanController::class, 'delete_karyawan'])->name('delete_karyawan');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
