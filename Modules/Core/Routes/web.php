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
// Override language route
Route::middleware('auth')->group(function () {

	Route::middleware('can:admin')->group(function () {
	
		Route::get(config('translation.ui_url').'/{language}/translations', 'LanguageTranslationController@index')->name('languages.translations.index');
	});

});
