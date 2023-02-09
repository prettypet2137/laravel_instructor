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

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Login with social accounts
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.social');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('login.callback');



Route::middleware('auth')->group(function () {
    // Profile
    Route::get('accountsettings', 'UserController@accountSettings')->name('accountsettings.index');
    Route::put('accountsettings', 'UserController@accountSettingsUpdate')->name('accountsettings.update');

    Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
        // Users
        Route::resource('users', 'UserController')->except('show');
        Route::get('users/impersonate/{id}', 'UserController@impersonate')->name('users.impersonate');
    });

    Route::get('users/leaveimpersonate', 'UserController@leaveimpersonate')->name('users.leaveimpersonate');

    Route::get('users/email', 'UserController@getUsersForEmail')->name('users.email');
    Route::post('users/email', 'UserController@sendEmailToUsers')->name('users.email.send');
});