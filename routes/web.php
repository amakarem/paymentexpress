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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/getways', 'HomeController@getways')->name('getways');
Route::post('/getwaysetup', 'HomeController@getwaysetup')->name('getwaysetup');
Route::get('/generatepaymentkey', 'HomeController@generatepaymentkey')->name('generatepaymentkey');
Route::get('/paymentlist', 'HomeController@paymentlist')->name('paymentlist');
Route::get('/checkout', function () {
    return view('checkout');
});
Route::post('/checkout', function () {
    return view('checkout');
});