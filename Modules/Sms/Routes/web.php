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

Route::prefix('sms')->group(function() {
    Route::prefix("admin")->name("sms.admin.")->namespace("Admin")->group(function() {
        Route::post("templates/test-sms", "SmsTemplateController@testSms")->name("templates.test-sms");
        Route::resource('templates', "SmsTemplateController");
        Route::put("setting/fee", "SmsSettingController@feeUpdate")->name("setting.fee-update");
        Route::post('setting/hires', 'SmsSettingController@hireStore')->name('setting.hire-store');
        Route::patch('setting/hires/{id}', 'SmsSettingController@hireEnable')->name('setting.hire-enable');
        Route::get('setting/hires/{id}', 'SmsSettingController@hireShow')->name('setting.hire-show');
        Route::put('setting/hires/{id}', 'SmsSettingController@hireUpdate')->name('setting.hire-update');
        Route::delete('setting/hires/{id}', 'SmsSettingController@hireDestroy')->name('setting.hire-destroy');
        Route::resource('setting', 'SmsSettingController');
    });
    Route::name('sms.user.')->namespace('User')->group(function() {
        Route::post("templates/enable-sms", "SmsTemplateController@enableSms")->name("templates.enable-sms");
        Route::post("templates/test-sms", "SmsTemplateController@testSms")->name("templates.test-sms");
        Route::post("templates/sms-checkout", "SmsTemplateController@smsCheckout")->name("templates.sms-checkout");
        Route::get("templates/sms-checkout-success", "SmsTemplateController@smsCheckoutSuccess")->name("templates.sms-checkout-success");
        Route::get("templates/sms-checkout-cancel", "SmsTemplateController@smsCheckoutCancel")->name("templates.sms-checkout-cancel");
        Route::get('templates/sms-checkout-notify', "SmsTemplateController@smsCheckoutNotify")->name("templates.sms-checkout-notify");
        Route::resource('templates', 'SmsTemplateController');
        Route::resource('histories', 'SmsHistoryController');
    });
});
