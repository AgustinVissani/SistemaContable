<?php

use Illuminate\Support\Facades\Route;



Route::get('/usuarios', 'App\Http\Controllers\ControllerUsuario@viewUsuarios')->name('usuarios');

Route::get('/altaUsuario', 'App\Http\Controllers\ControllerUsuario@altaUsuario')->name('altaUsuario');

Route::post('/altaUsuario', 'App\Http\Controllers\ControllerUsuario@altaUsuarioPost');

Route::get('/editUsuario/{id}', 'App\Http\Controllers\ControllerUsuario@editUsuario');

Route::post('/editUsuario/{id}', 'App\Http\Controllers\ControllerUsuario@editUsuarioPost');

Route::delete('/deleteUsuario/{id}', 'App\Http\Controllers\ControllerUsuario@deleteUsuario')->name('delete');

Route::get('/verUsuarios', 'App\Http\Controllers\ControllerUsuario@verUsuarios')->name('verUsuarios');

Route::get('users-list.pdf','App\Http\Controllers\ControllerUsuario@exportPdf')->name('users.pdf');

Route::get('users-list.xlsx','App\Http\Controllers\ControllerUsuario@exportxlsx')->name('users.xlsx');



//Roles

Route::get('/roles', 'App\Http\Controllers\ControllerUsuario@viewRoles')->name('roles');

Route::get('/altaRoles', 'App\Http\Controllers\ControllerUsuario@altaRoles')->name('altaRoles');

Route::post('/altaRoles', 'App\Http\Controllers\ControllerUsuario@altaRolPost');

Route::get('/editRol/{id}', 'App\Http\Controllers\ControllerUsuario@editRol');

Route::post('/editRol/{id}', 'App\Http\Controllers\ControllerUsuario@editRolPost');

Route::delete('/deleteRol/{id}', 'App\Http\Controllers\ControllerUsuario@deleteRol')->name('delete');
