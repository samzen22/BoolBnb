<?php

use Illuminate\Support\Facades\Route;

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

// questa route porta alla Homepage
Route::get('/', 'HomeController@index');

// routes di default per le autenticazioni
Auth::routes();

// routes per gli utenti registrati (upr)
Route::prefix('upr')
    ->namespace('Upr')
    ->middleware('auth')
    ->name('upr.')
    ->group(function () {
      Route::resource('apartments', 'ApartmentController');
      Route::get('/messages/{apartment}', 'ApartmentController@message')->name('message');
      Route::put('sospend/{apartment}', 'ApartmentController@sospend')->name('sospend');
      Route::post('apartments/{apartment}', 'ApartmentController@sponsorship')->name('sponsorship');
      Route::get('/payment/make', 'PaymentController@make')->name('payment.make');
    });

// routes per gli utenti non registrati
Route::resource('apartments','ApartmentController')->only('index','show');
Route::post('/apartments/{aparment}', 'MessageController@store')->name('message.store');
Route::get('/search','ApartmentController@search')->name('search');
