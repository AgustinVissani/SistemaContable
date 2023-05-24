<?php

use Illuminate\Support\Facades\Route;


Route::get('/backup', 'App\Http\Controllers\ControllerBackup@viewBack')->name('backup');


Route::post('/backup', 'App\Http\Controllers\ControllerBackup@realizarBackup');

Route::post('/restore', 'App\Http\Controllers\ControllerBackup@realizarRestore')->name('restore');

Route::delete('/deleteBackup/{name}', 'App\Http\Controllers\ControllerBackup@eliminarBackup')->name('delete');

Route::get('/downloadBackup/{name}', 'App\Http\Controllers\ControllerBackup@downloadZip')->name('download');
