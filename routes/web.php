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

Route::get('/', function () {
    return view('login');
});

Route::get('login', 'App\Http\Controllers\LoginController@login_form');
Route::post('login', 'App\Http\Controllers\LoginController@do_login');

Route::get('register', 'App\Http\Controllers\LoginController@register_form');
Route::post('register', 'App\Http\Controllers\LoginController@do_register');

Route::get('logout', 'App\Http\Controllers\LoginController@logout');

Route::get('home', 'App\Http\Controllers\CollectionController@home');
Route::get('carica_loghi', 'App\Http\Controllers\CollectionController@carica_loghi');

Route::get('auto_salvate', 'App\Http\Controllers\CollectionController@auto_salvate');
Route::get('carica_auto_salvate', 'App\Http\Controllers\CollectionController@carica_auto_salvate');

Route::get('specifiche_auto/{anno}/{marca}/{modello}', 'App\Http\Controllers\CollectionController@specifiche_auto');
Route::post('save_car', 'App\Http\Controllers\CollectionController@save_car');