<?php

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
    return view('welcome');
});
Route::post('archivo/guardarCambios/{id}','ArchivoController@guardarCambios');
Route::get('/user/listUsers','UserController@listUsers')->name('user.listUsers');
Route::get('/archivo/{id}/listArchivos/{get}','ArchivoController@listArchivos')->name('archivo.listArchivos');
Route::resource('user', 'UserController');
Route::resource('permisos', 'PermisosController');
Route::resource('archivo', 'ArchivoController');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
