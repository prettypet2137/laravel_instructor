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
Route::get('{name}/all-events', 'PublicEventsController@index')->name('all-events.index');
Route::get('{name}/categories/{id}', 'PublicEventsController@category_view')->name('category-events.index');
Route::get('{name}/events-calendar', 'PublicEventsController@calendar')->name('all-events.calendar');
Route::post('all-events/comment', 'CommentController@store')->name('all-events.comment');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'e', 'as' => 'events.public.', ], function(){
    // events
    Route::get('{qr_code_key}', 'PublicEventsController@getQrCode')->name('qr_code'); // link to get the qr_code
    Route::post('register/{slug}', 'PublicEventsController@register')->name('register');
    Route::get('upsell/{guest_code}/{upsell_id}', 'PublicEventsController@upsell')->name('upsell.index');
    Route::get('upsell/{guest_code}/{upsell_id}/{price}', 'PublicEventsController@upsellStore')->name('upsell.store');
    Route::get('checkout/{guest_code}', 'PublicEventsController@checkout')->name('checkout');
    Route::post('submit-checkout/{guest_code}', 'PublicEventsController@submitCheckout')->name('submitCheckout');
    
    Route::post('stripe/payment-intent', 'PublicEventsController@paymentIntent');
    Route::get('stripe/payment-intent/{guest_id}/return', 'PublicEventsController@paymentIntentReturn');
    Route::get('stripe/payment-intent/{guest_id}/cancel', 'PublicEventsController@paymentIntentCancel');
    Route::get('paypal/payment-intent/{guest_id}/return', 'PublicEventsController@paymentOrderReturn');
    Route::get('paypal/payment-intent/{guest_id}/cancel', 'PublicEventsController@paymentOrderCancel');
    
    Route::get('checkout/{event}/{guest}/return', 'PublicEventsController@gateway_return')->name('checkout.gateway.return');
    Route::get('checkout/{event}/{guest}/cancel', 'PublicEventsController@gateway_cancel')->name('checkout.gateway.cancel');
    Route::get('checkout/{event}/{guest}/notify', 'PublicEventsController@gateway_notify')->name('checkout.gateway.notify');

    Route::get('{name}/{slug?}', 'PublicEventsController@show')->name('show');
    Route::get('{name}/{slug}/terms-and-conditions', 'PublicEventsController@terms')->name('terms');

});

Route::middleware('auth')->group(function () {

    Route::get('checkin/{uuid}', 'PublicEventsController@checkin')->name('events.checkin');

    // guests
    Route::group(['prefix' => 'guests', 'as' => 'guests.', ], function(){
        Route::get('', 'GuestsController@index')->name('index');
        Route::get('data', 'GuestsController@data')->name('data');
        Route::post('delete/{id}', 'GuestsController@delete')->name('delete');
        Route::post('switch-status/{id}', 'GuestsController@switch_status')->name('switch_status');
        Route::post('switch-paid/{id}', 'GuestsController@switch_paid')->name('switch_paid');
        Route::get('get-detail/{id}', 'GuestsController@get_detail')->name('get_detail');
        Route::get('get-events/{id}', 'GuestsController@getEvents')->name('get_events');
        Route::post('transfer-guests', 'GuestsController@transferGuests')->name('transfer_guests');
        Route::get('confirm-ticket/{id}', 'GuestsController@confirmTicket')->name('confirm-ticket');
        Route::get('email', 'GuestsController@getGuestsForEmail')->name('email');
        Route::post('email', 'GuestsController@sendEmailToGuests')->name('email.send');
    });
    

    Route::post('getFonts', 'EventsController@getFonts');
    Route::get('all-events/comment', 'CommentController@index')->name('all-events.comment.index');

    Route::group(['prefix' => 'events', 'as' => 'events.', ], function(){
        // events
        Route::get('', 'EventsController@index')->name('index');
        Route::post('', 'EventsController@store')->name('store');
        Route::get('{id}/edit', 'EventsController@edit')->name('edit');
        Route::put('{id}', 'EventsController@update')->name('update');
        Route::delete('{id}', 'EventsController@delete')->name('delete');
        Route::post('copy/{id}', 'EventsController@copy')->name('copy');
        Route::get('sales-review/{id}', 'EventsController@salesReview')->name('sales-review');
        Route::get("get-upsell/{id}", 'EventsController@getUpsell')->name("get_upsell");
        Route::put("setting/show-form", "EventsController@updateShowForm")->name("update-show-form");
        
    });
    Route::group(
        ['prefix' => 'categories', 'as' => 'categories.'],
        function () {
            Route::get('', 'EventCategoriesController@index')->name('index');
            Route::get('{id}', 'EventCategoriesController@show')->name('show');
            Route::post('', 'EventCategoriesController@store')->name('store');
            Route::put('{id}', 'EventCategoriesController@update')->name('update');
            Route::delete('{id}', 'EventCategoriesController@destroy')->name('delete');
        }
    );

    Route::get('about','AboutController@index')->name('about.index');
    Route::post('about','AboutController@store')->name('about.store');
    Route::put('about/{id?}','AboutController@update')->name('about.update');
	Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
        Route::group(['prefix' => 'events', 'as' => 'events.', ], function(){
            // categories
            Route::group(['prefix' => 'categories', 'as' => 'categories.', ], function(){
                Route::get('', 'CategoriesController@index')->name('index');
                Route::get('create', 'CategoriesController@create')->name('create');
                Route::post('', 'CategoriesController@store')->name('store');
                Route::get('{id}/edit', 'CategoriesController@edit')->name('edit');
                Route::put('{id}', 'CategoriesController@update')->name('update');
                Route::delete('{id}', 'CategoriesController@delete')->name('delete');
               
            });
            Route::get('emaildefault', 'SettingsEventController@emaildefault')->name('emaildefault');
            Route::post('emaildefault/store', 'SettingsEventController@store')->name('emaildefault.store');

        });
	});
});


 // Saas module
 if (Module::find('Saas')) {
    Route::middleware('auth')->group(function () {
        // check number events
        Route::middleware('Modules\Saas\Http\Middleware\Billing')->group(function () {
            Route::group(['prefix' => 'events', 'as' => 'events.', ], function(){
                Route::post('', 'EventsController@store')->name('store');
                Route::put('{id}', 'EventsController@update')->name('update');
            });
        });
    });

    Route::middleware('Modules\Saas\Http\Middleware\Billing')->group(function () {
        // check number guests
        Route::group(['prefix' => 'e', 'as' => 'events.public.', ], function(){
            Route::post('event-register/{slug}', 'PublicEventsController@register')->name('register');
        });
    });
}