<?php


use App\Http\Controllers\GetdataController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('info', function () {
    phpinfo();
})->middleware("role:info");

Route::get('getdata/{model}', [GetdataController::class, 'getData'])
    ->middleware("role:getdata")
    ->name('getdata');
