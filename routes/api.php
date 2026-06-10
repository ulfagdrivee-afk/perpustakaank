<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Peminjaman_detailController;
use App\Http\Controllers\PengembalianController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
Route::post('auth/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function() {
Route::post('kategori', [KategoriController::class, 'store']);
Route::get('kategori', [KategoriController::class, 'index']);
Route::put('kategori/{id}', [KategoriController::class, 'update']);
Route::delete('kategori/{id}', [KategoriController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function() {
Route::post('penerbit', [PenerbitController::class, 'store']);
Route::get('penerbit', [PenerbitController::class, 'index']);
Route::put('penerbit/{id}', [PenerbitController::class, 'update']);
Route::delete('penerbit/{id}', [PenerbitController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->group(function() {
Route::post('buku', [BukuController::class, 'store']);
Route::get('buku', [BukuController::class, 'index']);
Route::put('buku/{id}', [BukuController::class, 'update']);
Route::delete('buku/{id}', [BukuController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->group(function() {
Route::post('anggota', [AnggotaController::class, 'store']);
Route::get('anggota', [AnggotaController::class, 'index']);
Route::put('anggota/{id}', [AnggotaController::class, 'update']);
Route::delete('anggota/{id}', [AnggotaController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->group(function() {
Route::post('peminjaman', [PeminjamanController::class, 'store']);
Route::get('peminjaman', [PeminjamanController::class, 'index']);
Route::put('peminjaman/{id}', [PeminjamanController::class, 'update']);
Route::delete('peminjaman/{id}', [PeminjamanController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->group(function() {
Route::post('peminjaman_detail', [Peminjaman_detailController::class, 'store']);
Route::get('peminjaman_detail', [Peminjaman_detailController::class, 'index']);
Route::put('peminjaman_detail/{id}', [Peminjaman_detailController::class, 'update']);
Route::delete('peminjaman_detail/{id}', [Peminjaman_detailController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function() {
Route::post('pengembalian', [PengembalianController::class, 'store']);
Route::get('pengembalian', [PengembalianController::class, 'index']);
Route::put('pengembalian/{id}', [PengembalianController::class, 'update']);
Route::delete('pengembalian/{id}', [PengembalianController::class, 'destroy']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
