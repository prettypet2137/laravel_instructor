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
Route::get('contacts', 'ContactsController@contacts')->name('contacts');
Route::post('contacts/save', 'ContactsController@save_contact')->name('contacts.save');

Route::middleware('auth')->group(function () {
	Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
    Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function() {
      Route::get('', 'ContactsController@index')->name('index');
      Route::delete('{id}', 'ContactsController@destroy')->name('destroy');
      Route::post('ajaxreaded', 'ContactsController@ajax_readed')->name('ajaxreaded');
    });
	});
});