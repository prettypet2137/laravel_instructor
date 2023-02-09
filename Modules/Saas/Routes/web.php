<?php






// Route API
Route::post('custom-domain/get-event', 'ApiController@getEvent');
Route::post('custom-domain/save-track-link', 'ApiController@saveTrackLink');
Route::post('custom-domain/register-event', 'ApiController@registerEvent');

// public function getLandingPage(Request $request)
//     {
//         if ($request->domain == getAppDomain()) {

//             $skin            = config('app.SITE_LANDING');
//             $currency_symbol         = config('app.CURRENCY_SYMBOL');
//             $currency_code   = config('app.CURRENCY_CODE');
//             $user            = $request->user();
//             return view('themes::' . $skin . '.home', compact(
//                 'user','currency_symbol','currency_code'
//             ));
//         }
//         else{

//             $page = $request->page;

//             $blockscss = replaceVarContentStyle(config('app.blockscss'));
//             $user = User::find($page->user_id);
//             $check_remove_brand = 0;

//             if (Module::find('Saas')) {
//                 $check_remove_brand = $user->checkRemoveBrand();
//             }

//             return view('landingpage::landingpages.publish_page', compact(
//                 'page','blockscss','check_remove_brand'
//             ));

//         }

//     }

Route::middleware('auth')->group(function () {
    // Billing
    Route::get('pricing', 'BillingController@listPackages')->name('pricing');
    Route::get('billing', 'BillingController@index')->name('billing.index');
    Route::delete('billing', 'BillingController@cancel')->name('billing.cancel');
    Route::get('billing/{package}', 'BillingController@package')->name('billing.package');
    // Payment gateway
    Route::post('billing/{package}/{gateway}', 'BillingController@gateway_purchase')->name('gateway.purchase');
    Route::get('billing/{payment}/return', 'BillingController@gateway_return')->name('gateway.return');
    Route::get('billing/{payment}/cancel', 'BillingController@gateway_cancel')->name('gateway.cancel');
    Route::get('billing/{payment}/notify', 'BillingController@gateway_notify')->name('gateway.notify');
    
    // Administrator
    Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
            // Packages
            Route::resource('packages', 'PackagesController')->except('show');
            Route::get('package-free', 'SettingController@packageFree')->name('package-free');
            Route::post('package-free-update', 'SettingController@packageFreeUpdate')->name('package-free-update');
            // Payments
            Route::get('payments', 'BillingController@payments')->name('payments');
            Route::get('payment-integrations', 'SettingController@paymentIntegrations')->name('payment-integrations');
            Route::post('payment-integrations-update', 'SettingController@paymentIntegrationsUpdate')->name('payment-integrations-update');

            Route::get('saas-settings', 'SettingController@settings')->name('saas.settings');
            Route::post('saas-update', 'SettingController@update')->name('saas.settings.update');

    });


});
