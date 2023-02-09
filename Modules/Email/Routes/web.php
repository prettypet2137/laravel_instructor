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
Route::prefix('email')->group(function() {
    Route::prefix('admin')->name('email.admin.')->namespace('Admin')->group(function() {
        Route::resource('templates', 'EmailTemplateController');
    });

    Route::name('email.user.')->namespace('User')->group(function() {
        Route::resource('templates', 'EmailTemplateController');
        Route::resource('histories', 'EmailHistoryController');
    });
});