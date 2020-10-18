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

Route::middleware('auth:api')->get('/loggedinuser', 'SiteController@getLoggedInUser');


//gebruiker zelf
Route::post('/reservations', 'ReservationController@store')->name('reservations.store');

//gebruiker of admin
Route::put('/reservations/{reservation}', 'ReservationController@update')->name('reservations.update');

//admin


Route::get('/types', 'TypeController@index');

Route::get('/artworks', 'ArtworkController@index')->middleware('auth:sanctum','can:update,Artwork');

Route::middleware('isAdmin')->group(function () {
    //artworks
    Route::post('/artworks', 'ArtworkController@store');
    Route::put('/artworks/{artwork}', 'ArtworkController@update');
    Route::get('/artworks/{artwork}', 'ArtworkController@show');
    Route::get('/artworks/{artwork}/image', 'ArtworkController@showImage');
    Route::delete('/artworks/{artwork}', 'ArtworkController@destroy');

    //users
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::post('/users', 'UserController@store')->name('users.store');
    Route::post('/users/{user}', 'UserController@update')->name('users.update');
    //vreemd
    Route::put('/users/{user}', 'UserController@update')->name('user.update');

    //reservations

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

    Route::get('sale/{artwork}', 'SaleController@show');

    //ontleningen
    Route::put('/rents/stop/{rent}', 'StopRentController');
    Route::post('vrijwilliger/{user}', 'VrijwilligerController@store');

    //roles

    Route::post('/roles/assign/{user}', 'RoleController@assign');
    Route::post('/roles/remove/{user}', 'RoleController@remove');

});


Route::post('artworks/code', 'CodeController');

//gebruiker zelf of admin
Route::get('/reservations', 'ReservationController@index')->name('reservations.index');
Route::middleware('auth:api')->get('/subscriptions', 'SubscriptionController@index');
Route::get('addresses/{user}', 'AddressController@show');

Route::middleware('auth:api')->get('/users/{user}', 'UserController@show')->name('users.show');


Route::apiResource('rents', 'RentController');

Route::post('/register', 'Auth\RegisterController@register');
Route::middleware('auth:api')->get('email/resend', 'Auth\VerificationController@resend');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('activate-email');

Route::post('login', 'Auth\AuthController@login');
Route::middleware('auth:api')->post('preferences', 'PreferenceController@setPreference')->name('setPreference');
Route::post('password/change', 'Auth\ResetPasswordController@update');

Route::middleware('auth:api')->post('/users', 'UserController@store');

Route::apiResource('orders', 'OrderController');
Route::apiResource('pays', 'PayController');
Route::apiResource('vouchers', 'VoucherController');
Route::apiResource('expires', 'ExpireController');
Route::apiResource('invoices', 'InvoiceController');
Route::apiResource('artists', 'ArtistController');

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



