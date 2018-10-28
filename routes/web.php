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

//Route::get('/stocktakeList','StocktakeController@list');

//Route::get('/stocktakeDetail','StocktakeController@detail');

Route::get('/file-upload','StocktakeController@upload');

Route::post('/file-upload','StocktakeController@process');

Route::get('/product-summary','ProductController@summary');

Route::get('/check-order','OrderController@orderCheckIn');

Route::post('/check-order','OrderController@processOrderCheckIn');

Route::get('/order','OrderController@index');

Route::get('/create-order','OrderController@createLorealOrder');

Route::get('/confirm-order','OrderController@confirmLorealOrder');

// Route::get('/stocktakeList', function () {
//
//     //$stocktakes = DB::select('SELECT stocktake_date FROM stocktakes GROUP BY stocktake_date;');
//
//     $stocktakes=DB::table('stocktakes')->select('stocktake_date')->distinct()->get();
//
//     //dd(compact('stocktakes'));
//
//     return view('stocktake-list', compact('stocktakes'));
// });
