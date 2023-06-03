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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
Route::get('framework', 'HomeController@framework')->name('framework')->middleware('auth');


Route::get('upload', 'FileController@index')->name('upload')->middleware('auth');
Route::post('upload/store', 'FileController@store')->name('upload.store')->middleware('auth');


Route::get('reconocimiento/procesado', 'ReconocimientoController@procesado')->name('reconocimiento.procesado')->middleware('auth');
Route::get('reconocimiento/historico', 'ReconocimientoController@historico')->name('reconocimiento.historico')->middleware('auth');
