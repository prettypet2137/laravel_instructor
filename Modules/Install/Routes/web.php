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

// Install
Route::middleware('installable')->group(function () {
    Route::get('install', 'InstallController@installCheck')->name('install.check');
    Route::get('installDB/{passed}', 'InstallController@installDB')->name('install.passed');
    Route::post('installDBPost', 'InstallController@installDBPost')->name('install.db');


    Route::get('installActive', 'InstallController@installActive')->name('install.active');
    Route::post('installActivePost', 'InstallController@installActivePost')->name('install.activepost');
});
