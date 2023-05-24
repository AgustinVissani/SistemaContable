<?php

use Illuminate\Support\Facades\Route;



Route::get('/clientes', 'App\Http\Controllers\ControllerCliente@viewClientes')->name('clientes');

Route::get('/altaCliente', 'App\Http\Controllers\ControllerCliente@altaCliente')->name('altaCliente');

Route::post('/altaCliente', 'App\Http\Controllers\ControllerCliente@altaClientePost');

Route::get('/editCliente/{id}', 'App\Http\Controllers\ControllerCliente@editCliente');

Route::post('/editCliente/{id}', 'App\Http\Controllers\ControllerCliente@editClientePost');

Route::delete('/deleteCliente/{id}', 'App\Http\Controllers\ControllerCliente@deleteCliente')->name('delete');

Route::get('/verCliente/{id}', 'App\Http\Controllers\ControllerCliente@verCliente')->name('verCliente');

Route::get('/verClientes', 'App\Http\Controllers\ControllerCliente@verClientes')->name('verClientes');

Route::get('client-list.pdf','App\Http\Controllers\ControllerCliente@exportPdf')->name('cliente.pdf');

Route::get('client-list.xlsx','App\Http\Controllers\ControllerCliente@exportxlsx')->name('cliente.xlsx');

//sexo

Route::get('/sexos', 'App\Http\Controllers\ControllerCliente@viewSexos')->name('sexos');

Route::get('/altaSexo', 'App\Http\Controllers\ControllerCliente@altaSexo')->name('altaSexo');

Route::post('/altaSexo', 'App\Http\Controllers\ControllerCliente@altaSexoPost');

Route::get('/editSexo/{id}', 'App\Http\Controllers\ControllerCliente@editSexo');

Route::post('/editSexo/{id}', 'App\Http\Controllers\ControllerCliente@editSexoPost');

Route::delete('/deleteSexo/{id}', 'App\Http\Controllers\ControllerCliente@deleteSexo')->name('delete');
