<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('auth/refresh', [AuthController::class, 'refresh'])->middleware('auth');
Route::post('auth/me', [AuthController::class, 'me'])->middleware('auth');