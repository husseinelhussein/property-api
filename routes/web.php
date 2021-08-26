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
\Illuminate\Support\Facades\Auth::routes();
Route::get('/', 'App\Http\Controllers\PropertyController@index')->name('property.index');
Route::get('/filter', 'App\Http\Controllers\PropertyController@filter')->name('property.filter');
Route::resource('/show/{id}', 'App\Http\Controllers\PropertyController@show')->name('property.show');
Route::DELETE('/delete/{id}', 'App\Http\Controllers\PropertyController@destroy')
    ->middleware('auth')
    ->name('property.delete');
