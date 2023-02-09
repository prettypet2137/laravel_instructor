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

    Route::get("feature/get-features", "FeatureController@getFeatures")->name("feature.get_features");
    Route::resource('feature', 'FeatureController');
