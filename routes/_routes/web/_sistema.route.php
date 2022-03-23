<?php


use App\Http\Controllers\GetdataController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('info', function () {
    phpinfo();
});
Route::view('dashboard', 'dashboard.index')->name('dashboard');
Route::get('getdata/{model}', [GetdataController::class, 'getData'])->name('getdata');


// Route::get('logs', [LogsController::class, 'index'])->name('logs.index');
// Route::get('logs/data', [LogsController::class, 'data'])->name('logs.data');

// Route::get('forgetpassword', function () {
//     return new UserForgetPassword();
//     // Mail::to('tuliogoncalves@gmail.com')->send(new UserForgetPassword());
// });
