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
Route::get('blogs', 'BlogsController@getBlogs')->name('blogs');
Route::get('blogs/{id}-{slug}', 'BlogsController@getBlog')->name('blog');

Route::middleware('auth')->group(function () {
	Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
		// categories
		Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function(){
      Route::resource('categories', 'CategoriesController')->except('show');
		});
	
		// blogs
		Route::resource('blogs', 'BlogsController')->except('show');
		Route::post('blogs/upload-image', 'BlogsController@upload_image')->name('blogs.upload_image');
	});
});
		
