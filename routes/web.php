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

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::group([
    'prefix' => 'auth',
], function () {
    Route::get('login', 'AuthenticationController@index')->name('auth')->middleware('guest');
    Route::post('login', 'AuthenticationController@login')->name('auth.login')->middleware('guest');
    Route::get('register', 'AuthenticationController@showRegister')->name('auth.register')->middleware('guest');
    Route::post('register', 'AuthenticationController@register')->name('auth.register')->middleware('guest');
    Route::post('logout', 'AuthenticationController@logout')->name('auth.logout')->middleware('auth');
});
