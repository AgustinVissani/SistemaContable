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

Route::get('/', function () {
    return view('welcome');
});

// ->middleware(['auth'])


require __DIR__.'/auth.php';

require __DIR__.'/routeClientes.php';
require __DIR__.'/routeProvincias.php';
require __DIR__.'/routeplanCuentas.php';
require __DIR__.'/routeInicio.php';
require __DIR__.'/routeUsuario.php';
require __DIR__.'/routeAudit.php';
require __DIR__.'/routeBackup.php';
require __DIR__.'/routeAsientos.php';
