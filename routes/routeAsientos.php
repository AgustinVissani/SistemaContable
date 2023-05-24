<?php

use Illuminate\Support\Facades\Route;



Route::get('/asientos', 'App\Http\Controllers\ControllerAsiento@viewAsiento')->name('asientos');

Route::post('/altaAsientos', 'App\Http\Controllers\ControllerAsiento@altaAsientosPost');

Route::post('/altaAsientoOk', 'App\Http\Controllers\ControllerAsiento@altaAsientoOkPost');

Route::post('/cancelarAsiento', 'App\Http\Controllers\ControllerAsiento@cancelarAsiento');

Route::post('/editAsiento', 'App\Http\Controllers\ControllerAsiento@editRenglonesPost')->name('editAsiento');

Route::delete('/deleteAsiento/{id}', 'App\Http\Controllers\ControllerAsiento@deleteAsiento')->name('deleteAsiento');

Route::post('/registrarAsiento/{id}', 'App\Http\Controllers\ControllerAsiento@registrarAsiento')->name('registrarAsiento');

Route::post('/registrarDH', 'App\Http\Controllers\ControllerAsiento@registrarDH')->name('registrarDH');

Route::post('/altaAsientoOkRegistro', 'App\Http\Controllers\ControllerAsiento@altaAsientoOkRegistradoPost')->name('altaAsientoOkRegistro');

Route::get('/verAsientos', 'App\Http\Controllers\ControllerAsiento@verAsientos')->name('verAsientos');

// Route::get('asientos-list.pdf','App\Http\Controllers\ControllerAsiento@exportPdf')->name('asientos.pdf');

Route::get('asientosH-list.pdf','App\Http\Controllers\ControllerAsiento@exportPdfHorizontal')->name('asientosH.pdf');

Route::post('/asientosDH','App\Http\Controllers\ControllerAsiento@exportPdfDH');

Route::get('asientos-list.xlsx','App\Http\Controllers\ControllerAsiento@exportxlsx')->name('asientos.xlsx');


//renglones

Route::delete('/deleteRenglon/{id}', 'App\Http\Controllers\ControllerAsiento@deleteRenglon')->name('deleteRenglon');

Route::get('/renglones/{id}', 'App\Http\Controllers\ControllerAsiento@viewRenglones')->name('renglones');

Route::post('/altaRenglones', 'App\Http\Controllers\ControllerAsiento@altaRenglonesPost');

//diario-mayor

Route::get('/diariomayor', 'App\Http\Controllers\ControllerAsiento@viewDiarioMayor')->name('diariomayor');

Route::get('diariomayorH-list.pdf','App\Http\Controllers\ControllerAsiento@exportPdfHdiariomayor')->name('diariomayorH.pdf');

Route::get('mayoresdecuentas-list.pdf','App\Http\Controllers\ControllerAsiento@exportPdfmayoresdecuentas')->name('mayoresdecuentas.pdf');

Route::post('diariosDH','App\Http\Controllers\ControllerAsiento@exportPdfdiarioDH')->name('diarioDH');

Route::post('libroDH','App\Http\Controllers\ControllerAsiento@exportPdfHdiariomayorDH')->name('libroDH');




//balances

Route::get('/listadoBalance', 'App\Http\Controllers\ControllerBalance@listarBalance')->name('listadoBalance');

Route::get('balance-list.pdf','App\Http\Controllers\ControllerBalance@exportPdfbalance')->name('balance.pdf');

Route::post('balancesDH','App\Http\Controllers\ControllerBalance@exportPdfbalanceDH')->name('balancesDH');

