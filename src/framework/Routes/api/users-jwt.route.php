<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('users/sql', [UserController::class, 'toSql'])->middleware('roles:users.sql');
Route::get('users/db', [UserController::class, 'queryDb'])->middleware('roles:users.db');
Route::get('users/query', [UserController::class, 'query'])->middleware('roles:users.index');

Route::get('users', [UserController::class, 'index'])->middleware('roles:users.index');
Route::get('users/create', [UserController::class, 'create'])->middleware('roles:users.create');
Route::get('users/{id}/edit', [UserController::class, 'edit'])->middleware('roles:users.edit');
Route::get('users/{id}/show', [UserController::class, 'show'])->middleware('roles:users.show');
Route::post('users', [UserController::class, 'store'])->middleware('roles:users.store');
Route::put('users/{id}', [UserController::class, 'update'])->middleware('roles:users.update');
Route::delete('users/{id}', [UserController::class, 'delete'])->middleware('roles:users.delete');

Route::get('version', [UserController::class, 'getVersion'])->middleware('roles');