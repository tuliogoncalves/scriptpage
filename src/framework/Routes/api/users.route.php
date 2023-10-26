<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('users/sql', [UserController::class, 'toSql']);
// Route::get('users/db', [UserController::class, 'queryDb']);
// Route::get('users/query', [UserController::class, 'query']);

Route::get('users', [UserController::class, 'index']);
Route::get('users/create', [UserController::class, 'create']);
Route::get('users/{id}/edit', [UserController::class, 'edit']);
Route::get('users/{id}/show', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'delete']);

// Route::get('version', [UserController::class, 'getVersion']);