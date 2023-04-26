<?php


use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;


Route::resource('clients', ClientController::class);