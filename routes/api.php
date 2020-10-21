<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/artworks', 'ArtworkController@index');
Route::get('/artworks/{artwork}', 'ArtworkController@show');
Route::get('/artworks/{artwork}/image', 'ArtworkController@showImage');

Route::get('/types', 'TypeController@index');

Route::get('/artists','ArtistController@index');
Route::get('artists/{artist}','ArtistController@show');



Route::middleware('auth:sanctum')->group(function(){

    //ARTWORK


    Route::post('/artworks', 'ArtworkController@store')->middleware('can:create:artwork');
    Route::put('/artworks/{artwork}', 'ArtworkController@update')->middleware('can:update,artwork');
    Route::delete('/artworks/{artwork}', 'ArtworkController@destroy')->middleware('can:delete,artwork');

    Route::get('sale/{artwork}', 'SaleController@show');

    Route::post('artworks/code', 'CodeController');

    //ARTIST
    Route::apiResource('artists', 'ArtistController')->except(['index','show']);


    //USER
    Route::get('/loggedinuser', 'SiteController@getLoggedInUser');
    //users
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::post('/users', 'UserController@store')->name('users.store');
    Route::post('/users/{user}', 'UserController@update')->name('users.update');
    //vreemd ==> naam is niet hetzelfde
    Route::put('/users/{user}', 'UserController@update')->name('user.update');


    //abonnementen
    Route::post('/subscriptions', 'SubscriptionController@store');
    Route::get('/subscriptions/{subscription}', 'SubscriptionController@show');
    Route::put('/subscriptions/{subscription}', 'SubscriptionController@update');
    Route::delete('/subscriptions/{subscription}', 'SubscriptionController@destroy');
    Route::get('/subscriptions/number/get','SubscriptionController@getNumber');

    //types
    Route::post('/types', 'TypeController@store');
    Route::put('/types/{type}', 'TypeController@update');

    Route::post('sale', 'SaleController@store');


    //ontleningen
    Route::put('/rents/stop/{rent}', 'StopRentController');
    Route::post('vrijwilliger/{user}', 'VrijwilligerController@store');

});





//gebruiker zelf
Route::post('/reservations', 'ReservationController@store')->name('reservations.store');

//gebruiker of admin
Route::put('/reservations/{reservation}', 'ReservationController@update')->name('reservations.update');

//admin





//admin routes
Route::middleware('isAdmin','auth:sanctum')->group(function () {
    //artworks




    //reservations





    //roles

    Route::post('/roles/assign/{user}', 'RoleController@assign');
    Route::post('/roles/remove/{user}', 'RoleController@remove');
//gebruiker zelf of admin
    Route::get('/reservations', 'ReservationController@index')->name('reservations.index');
    Route::get('/subscriptions', 'SubscriptionController@index');
    Route::get('addresses/{user}', 'AddressController@show');

    Route::get('/users/{user}', 'UserController@show')->name('users.show');


    Route::apiResource('rents', 'RentController');

    Route::post('/register', 'Auth\RegisterController@register');
    Route::get('email/resend', 'Auth\VerificationController@resend');
    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('activate-email');

    Route::post('login', 'Auth\AuthController@login');
    Route::post('preferences', 'PreferenceController@setPreference')->name('setPreference');
    Route::post('password/change', 'Auth\ResetPasswordController@update');

    Route::middleware('auth:api')->post('/users', 'UserController@store');

    Route::apiResource('orders', 'OrderController');
    Route::apiResource('pays', 'PayController');
    Route::apiResource('vouchers', 'VoucherController');
    Route::apiResource('expires', 'ExpireController');
    Route::apiResource('invoices', 'InvoiceController');

    Route::post('/vouchers/check', 'VoucherController@check');
    Route::get('banktransferts/check/{statement}', 'BankTransfertController@check');
    Route::apiResource('banktransferts', 'BankTransfertController');
    Route::apiResource('cashs', 'CashController');
    Route::apiResource('voucherpays', 'VoucherPayController');
    Route::apiResource('confirmds', 'ConfirmController');


//Route::middleware('auth:api')->post('artworkavailable', 'ArtworkController@notifyAvailable');
    Route::middleware('auth:api')->post('artworkavailable/{artwork}', 'notifyAvailableController');

    Route::middleware('auth:api')->put('expire/update', 'UpdateExpireController');

    Route::middleware('isAdmin')->post('issold', 'ArtworkController@sold');


    Route::middleware('auth:api')->get('/orders', 'OrderController@index');


    Route::post('/newsletter/subscribe/{user}','NewsletterController@subscribe');
    Route::get('/newsletter/subscribeall','NewsletterController@storeAll');
    Route::get('/newsletter/getmembers','NewsletterController@getMembers');
    Route::post('/newsletter/addTag/{user}','NewsletterController@addTag');
    Route::post('/newsletter/isSubscribed/{user}','NewsletterController@isSubscribed');
    Route::get('/newsletter/geterror','NewsletterController@getError');
    Route::get('/mailchimp','MailchimpController@get');
    Route::post('/mailchimp','MailchimpController@store');
    Route::get('/mailchimp/api/event/{user}','MailchimpController@event');
});


//Data

Route::get('data','LandingController@read');
Route::post('data','LandingController@write')->middleware('auth:sanctum');







