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

// Authorized users
Route::middleware('auth')->group(function () {

    Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
        // Upgrade
        Route::get('modulesmanager', 'ModulesManagerController@index')->name('modulesmanager.index');
        Route::get('migreatemodule/{type}', 'ModulesManagerController@migrateModule')->name('modulesmanager.migreatemodule');
        Route::post('modulesmanager/install', 'ModulesManagerController@install')->name('modulesmanager.install');
        Route::post('modulesmanager/update/{product_id}', 'ModulesManagerController@update')->name('modulesmanager.update');


    });

});