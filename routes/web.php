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

//Route::get('/stocktake','StocktakeController@index');

//Route::post('/stocktake','StocktakeController@process');

// Route::get('/check-order','OrderController@orderCheckIn');
//

//
// Route::get('/order','OrderController@index');
//
// Route::get('/order/{order}','OrderController@detail');
//
// Route::get('/create-order','OrderController@createLorealOrder');
//
// Route::get('/confirm-order','OrderController@confirmLorealOrder');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('products', 'ProductController');

Route::resource('orders', 'OrderController');

//Route::get('/check-order','OrderController@selectOrderCheckIn');

Route::get('/order-check/{order}','OrderController@selectOrderCheckIn');

Route::post('/order-confirm/{order}','OrderController@confirmOrder');

Route::post('/check-order','OrderController@processOrderCheckIn');

Route::resource('stocktakes', 'StocktakeController');

Route::get('/allProducts', 'ProductController@getProducts')->name('all_products_data');
