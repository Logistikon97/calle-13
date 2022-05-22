<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatosController;
use App\Models\Datos;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.login');
});

Route::resource('servicio', DatosController::class)->middleware('auth');
Auth::routes();

//Route::get('/inicio', [DatosController::class, 'index'])->name('inicio')->middleware('auth');

Route::get('/consultar', function () {
    return view('servicio.consulta');
})->name('abonados')->middleware('auth');

Route::get('/listones', function () {
    return view('servicio.listones');
})->middleware('auth');

Route::post('/consultar/abonado', [DatosController::class, 'consultarAbonado'])->name('consultarAbonados')->middleware('auth');
Route::post('/consultar/puertos', [DatosController::class, 'consultarPuertos'])->name('consultarPuertos')->middleware('auth');
Route::post('/listones/mostrar', [DatosController::class, 'consultarPorListon'])->name('mostrarListon')->middleware('auth');
Route::get('/listones/mostrar', function(){
    return view('servicio.listones');
})->name('mostrarListon')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DatosController::class, 'index'])->name('home');
});
