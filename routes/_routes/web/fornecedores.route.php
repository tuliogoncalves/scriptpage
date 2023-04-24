<?php


use App\Http\Controllers\FornecedoresController;
use Illuminate\Support\Facades\Route;

Route::resource('fornecedores', FornecedoresController::class);