<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// autentikasi
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');

// berita
Route::get('berita','Api\beritaController@index');
Route::post('berita/store','Api\beritaController@store');
Route::get('berita/show/{url}','Api\beritaController@show');
Route::post('berita/update/{url}','Api\beritaController@update');
Route::get('berita/delete/{id}','Api\beritaController@delete');
