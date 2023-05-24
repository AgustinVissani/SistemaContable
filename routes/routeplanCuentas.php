<?php

use Illuminate\Support\Facades\Route;



Route::get('/planCuentas', 'App\Http\Controllers\ControllerplanCuenta@viewplanCuenta')->name('planCuentas');

Route::get('/altaplanCuenta', 'App\Http\Controllers\ControllerplanCuenta@altaplanCuenta')->name('altaplanCuenta');

Route::post('/altaplanCuenta', 'App\Http\Controllers\ControllerplanCuenta@altaplanCuentaPost');

Route::get('/editplanCuenta/{id}', 'App\Http\Controllers\ControllerplanCuenta@editplanCuenta');

Route::post('/editplanCuenta/{id}', 'App\Http\Controllers\ControllerplanCuenta@editplanCuentaPost');

Route::delete('/deleteplanCuentas/{id}', 'App\Http\Controllers\ControllerplanCuenta@deleteplanCuentas')->name('deleteplanCuentas');

Route::get('/verplanCuenta/{id}', 'App\Http\Controllers\ControllerplanCuenta@verplanCuenta')->name('verplanCuenta');

Route::get('/verplanCuentas', 'App\Http\Controllers\ControllerplanCuenta@verplanCuentas')->name('verplanCuentas');

Route::get('planCuentas-list.pdf','App\Http\Controllers\ControllerplanCuenta@exportPdf')->name('planCuentas.pdf');

Route::get('planCuentas-list.xlsx','App\Http\Controllers\ControllerplanCuenta@exportxlsx')->name('planCuentas.xlsx');
