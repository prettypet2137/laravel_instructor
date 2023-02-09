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
// Page Home page
Route::get('page/{slug}', 'PagesWebsiteController@pageWebsite')->name('pagewebsite');

Route::middleware('auth')->group(function () {
	Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
		Route::resource('pagewebsites', 'PagesWebsiteController')->except('show');
	});
});