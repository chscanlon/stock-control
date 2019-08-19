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

Route::get('/','HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('products', 'ProductController');

Route::resource('orders', 'OrderController');

Route::post('/order-confirm/{order}','OrderController@confirmOrder');

Route::get('/order-check-in-delivery/{order}','OrderController@selectOrderCheckIn');

Route::post('/order-check-in-delivery/{order}','OrderController@processOrderCheckIn');

Route::get('/order-export-pdf/{order}','OrderController@exportPdf');

Route::resource('stocktakes', 'StocktakeController');
