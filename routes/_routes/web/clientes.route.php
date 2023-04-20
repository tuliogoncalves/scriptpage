<?php


use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::resource('clientes', ClienteController::class);
