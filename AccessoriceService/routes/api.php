<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('banners','Api\HomeController@getBanners')->name('banners.index');

Route::get('brands','Api\HomeController@getBrands')->name('brands.index');

Route::post('categories','Api\HomeController@getCategory')->name('categories.index');

Route::post('products','Api\HomeController@getProducts')->name('products.index');
Route::get('productall','Api\HomeController@getProductsAll')->name('products.all.index');
Route::post('productsbyid','Api\HomeController@getProductById')->name('products.id.index');
Route::post('imagesproduct','Api\HomeController@getImagesProduct')->name('products.images.index');

Route::post('login','Api\HomeController@doLogin')->name('login');
Route::post('register','Api\HomeController@doRegister')->name('register');
Route::post('checkcustomer','Api\HomeController@doCheck')->name('check');
Route::post('avatar','Api\HomeController@doUploadAV')->name('avatar');

Route::post('order','Api\HomeController@doOrder')->name('order');
Route::post('invoicelist','Api\HomeController@allInvoice')->name('all.invoice');
Route::post('history','Api\HomeController@allHistory')->name('all.history');
Route::post('invoiceDetail','Api\HomeController@allInvoiceDetail')->name('detail.invoice');
Route::post('canceled','Api\HomeController@doCanceled')->name('cancel.invoice');
Route::post('change-info','Api\HomeController@doChangeInfo')->name('change.info');