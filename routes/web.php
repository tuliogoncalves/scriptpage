<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {

    /**
     * Rotas de Sistema Global Autenticada ...
     *
     * @return string
     */
    incluirRota('_sistema.route.php', 'web');

    /**
     * Rotas de USUÁRIOS -[users] em geral..
     *
     * @return string
     */
    incluirRota('_users.route.php', 'web');


});

/**
 * Rotas de LOGIN -[login] em geral..
 *
 * @return string
 */
incluirRota('_login_all.route.php', 'web');

