<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('info', function () {
//     phpinfo();
// })->middleware("role:info.index");
