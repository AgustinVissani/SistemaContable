<?php

use Illuminate\Support\Facades\Route;

Route::get('/audit', 'App\Http\Controllers\ControllerAudit@verAudit')->name('audits');

Route::get('/auditCompleta', 'App\Http\Controllers\ControllerAudit@verAuditCompleta')->name('auditsCompleta');

Route::get('/valorNuevo/{id}', 'App\Http\Controllers\ControllerAudit@valorNuevo')->name('valorNuevo');

Route::get('/valor/{id}', 'App\Http\Controllers\ControllerAudit@valor')->name('valor');

Route::get('audit-list.pdf','App\Http\Controllers\ControllerAudit@exportPdf')->name('audit.pdf');

Route::get('audit-list.xlsx','App\Http\Controllers\ControllerAudit@exportxlsx')->name('audit.xlsx');
