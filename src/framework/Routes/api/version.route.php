<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('version', [UserController::class, 'getVersion'])->middleware('roles');