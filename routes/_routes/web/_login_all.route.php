<?php


use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate'])->name('login.do');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// workscript routes
// include __DIR__ . '/workscript.php';
