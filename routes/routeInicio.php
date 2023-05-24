<?php

use Illuminate\Support\Facades\Route;


Route::get('/inicio', 'App\Http\Controllers\ControllerInicio@viewInicio')->name('inicio');


Route::post('/seleccionEmpresa', 'App\Http\Controllers\ControllerInicio@seleccionEmpresaPost')->name('seleccionEmpresa');



// EMPRESAS


Route::get('/empresas', 'App\Http\Controllers\ControllerInicio@viewEmpresas')->name('empresas');

Route::get('/altaEmpresa', 'App\Http\Controllers\ControllerInicio@altaEmpresa')->name('altaEmpresa');

Route::post('/altaEmpresa', 'App\Http\Controllers\ControllerInicio@altaEmpresaPost');

Route::get('/editEmpresa/{id}', 'App\Http\Controllers\ControllerInicio@editEmpresa');

Route::post('/editEmpresa/{id}', 'App\Http\Controllers\ControllerInicio@editEmpresaPost');

Route::get('/editdatosEmpresa/{id}', 'App\Http\Controllers\ControllerInicio@editdatosEmpresa');

Route::post('/editdatosEmpresa/{id}', 'App\Http\Controllers\ControllerInicio@editdatosEmpresaPost');

Route::delete('/deleteEmpresa/{id}', 'App\Http\Controllers\ControllerInicio@deleteEmpresa')->name('delete');


//SUCURSAL


Route::get('/sucursales', 'App\Http\Controllers\ControllerInicio@viewSucursal')->name('sucursales');

Route::get('/altaSucursal', 'App\Http\Controllers\ControllerInicio@altaSucursal')->name('altaSucursal');

Route::post('/altaSucursal', 'App\Http\Controllers\ControllerInicio@altaSucursalPost');

Route::get('/editSucursal/{id}', 'App\Http\Controllers\ControllerInicio@editSucursal');

Route::post('/editSucursal/{id}', 'App\Http\Controllers\ControllerInicio@editSucursalPost');

Route::delete('/deleteSucursal/{id}', 'App\Http\Controllers\ControllerInicio@deleteSucursal')->name('delete');


//SECCION

Route::get('/secciones', 'App\Http\Controllers\ControllerInicio@viewSeccion')->name('secciones');

Route::get('/altaSeccion', 'App\Http\Controllers\ControllerInicio@altaSeccion')->name('altaSeccion');

Route::post('/altaSeccion', 'App\Http\Controllers\ControllerInicio@altaSeccionPost');

Route::get('/editSeccion/{id}', 'App\Http\Controllers\ControllerInicio@editSeccion');

Route::post('/editSeccion/{id}', 'App\Http\Controllers\ControllerInicio@editSeccionPost');

Route::delete('/deleteSeccion/{id}', 'App\Http\Controllers\ControllerInicio@deleteSeccion')->name('delete');
