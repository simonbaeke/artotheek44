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


Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/profile', 'HomeController@index')->name('home');

Route::get('/catalogus', 'HomeController@index')->name('home');

Route::get('/artiesten', 'HomeController@index');

Route::get('/artiesten/{id}', 'HomeController@index');

Route::get('/showlogin', 'HomeController@login')->middleware('guest')->name('showlogin');


Route::middleware('isAdmin')->group(function () {

    Route::get('/admin', 'HomeController@index');

    Route::get('/admin/{any}', 'HomeController@index')->where('any', '.*');

});


Route::get('mailable', function () {

    return new App\Mail\testEmail();
});




