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
     * Home routes
     */
    addRoute('web/home');

    /**
     * Users routes
     */
    addRoute('web/users');


    /**
     * Users clientes
     */
    
<<<<<<< HEAD
    addRoute('web/clientes');

    /**
     * Users Fornecedores
     */
    
     addRoute('web/fornecedores');


=======
    addRoute('web/clients');
>>>>>>> e0db464f58c50d51789226d675e254ea1fad349b
});


/**
 * Login routes
 */
addRoute('web/login');
