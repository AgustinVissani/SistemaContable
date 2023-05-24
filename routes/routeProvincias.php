<?php

use Illuminate\Support\Facades\Route;


Route::get('/provincias', 'App\Http\Controllers\ControllerProvincia@viewProvicias')->name('provincias');

Route::get('/altaProvincia', 'App\Http\Controllers\ControllerProvincia@altaProvincia')->name('altaProvincia');

Route::post('/altaProvincia', 'App\Http\Controllers\ControllerProvincia@altaProvinciaPost');

Route::get('/editProvincia/{id}', 'App\Http\Controllers\ControllerProvincia@editProvincia');

Route::post('/editProvincia/{id}', 'App\Http\Controllers\ControllerProvincia@editProvinciaPost');

Route::delete('/deleteProvincia/{id}', 'App\Http\Controllers\ControllerProvincia@deleteProvincia')->name('delete');

Route::get('/verProvincia/{id}', 'App\Http\Controllers\ControllerProvincia@verProvincia')->name('verProvincia');

Route::get('provincia-list.pdf','App\Http\Controllers\ControllerProvincia@exportPdf')->name('provincia.pdf');

Route::get('provincia-list.xlsx','App\Http\Controllers\ControllerProvincia@exportxlsx')->name('provincia.xlsx');

Route::get('/verProvincias', 'App\Http\Controllers\ControllerProvincia@verProvincias')->name('verProvincias');


