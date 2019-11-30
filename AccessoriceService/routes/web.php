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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/','Shop\HomeController@index');


Auth::routes();

Route::group(['middleware' => 'locale'], function(){

    Route::get('/admins', function (){
       return redirect()->route('dashboard');
    });

    Route::group(['prefix' => 'admins'], function () {
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');

        Route::group(['prefix' => 'banner'], function () {
            Route::get('/list', 'Admin\BannerController@index')->name('banner.list');
            Route::get('/add', 'Admin\BannerController@add')->name('banner.add');
            Route::post('/add', 'Admin\BannerController@doAdd')->name('banner.submit.add');
            Route::get('/edit/{id}', 'Admin\BannerController@edit')->name('banner.edit');
            Route::post('/edit', 'Admin\BannerController@doEdit')->name('banner.submit.edit');
            Route::post('/delete','Admin\BannerController@doDelete')->name('banner.submit.delete');

        });

        Route::group(['prefix' => 'brand'], function () {
            Route::get('/list', 'Admin\BrandController@index')->name('brand.list');
            Route::get('/add', 'Admin\BrandController@add')->name('brand.add');
            Route::post('/add', 'Admin\BrandController@doAdd')->name('brand.submit.add');
            Route::get('/edit/{id}', 'Admin\BrandController@edit')->name('brand.edit');
            Route::post('/edit', 'Admin\BrandController@doEdit')->name('brand.submit.edit');
            Route::post('/delete','Admin\BrandController@doDelete')->name('brand.submit.delete');
        });

        Route::group(['prefix' => 'customer'], function () {
            Route::get('/list', 'Admin\CustomerController@index')->name('customer.list');
            Route::get('/add', 'Admin\CustomerController@add')->name('customer.add');
            Route::get('/edit', 'Admin\CustomerController@edit')->name('customer.create');
        });

        Route::group(['prefix' => 'discount'], function () {
            Route::get('/list', 'Admin\DiscountController@index')->name('discount.list');
            Route::get('/add', 'Admin\DiscountController@add')->name('discount.add');
            Route::post('/add', 'Admin\DiscountController@doAdd')->name('discount.submit.add');
            Route::get('/edit/{id}', 'Admin\DiscountController@edit')->name('discount.edit');
            Route::post('/edit', 'Admin\DiscountController@doEdit')->name('discount.submit.edit');
            Route::post('/delete','Admin\DiscountController@doDelete')->name('discount.submit.delete');
        });

        Route::group(['prefix' => 'invoice'], function () {
            Route::get('/list', 'Admin\InvoiceController@index')->name('invoice.list');
            Route::get('/add', 'Admin\InvoiceController@add')->name('invoice.add');
            Route::post('/add', 'Admin\InvoiceController@doAdd')->name('invoice.submit.add');
            Route::get('/edit/{id}', 'Admin\InvoiceController@edit')->name('invoice.edit');
            Route::post('/edit', 'Admin\InvoiceController@doEdit')->name('invoice.submit.edit');
            Route::post('/delete', 'Admin\InvoiceController@doDelete')->name('invoice.submit.delete');
            Route::get('/detail/{id}', 'Admin\InvoiceController@detail')->name('invoice.detail');
            Route::get('/export/{id}', 'Admin\InvoiceController@exportInvoice')->name('invoice.export');
        });

        Route::group(['prefix' => 'product'], function () {
            Route::get('/list', 'Admin\ProductController@index')->name('product.list');
            Route::get('/add', 'Admin\ProductController@add')->name('product.add');
            Route::get('/edit/{id}', 'Admin\ProductController@edit')->name('product.edit');
            Route::get('/detail/{id}', 'Admin\ProductController@detail')->name('product.detail');
            Route::post('/add','Admin\ProductController@doAdd')->name('product.submit.add');
            Route::post('/edit','Admin\ProductController@doEdit')->name('product.submit.edit');
            Route::post('/delete','Admin\ProductController@doDelete')->name('product.submit.delete');
            Route::post('/add/image','Admin\ProductController@doAddImage')->name('product.submit.add.image');
            Route::post('/delete/image','Admin\ProductController@doDeleteImage')->name('product.submit.delete.image');
        });

        Route::group(['prefix' => 'product-category'], function () {
            Route::get('/list', 'Admin\ProductCategoryController@index')->name('product.category.list');
            Route::get('/add', 'Admin\ProductCategoryController@add')->name('product.category.add');
            Route::get('/edit/{id}', 'Admin\ProductCategoryController@edit')->name('product.category.edit');
            Route::post('/add', 'Admin\ProductCategoryController@doAdd')->name('product.category.submit.add');
            Route::post('/edit', 'Admin\ProductCategoryController@doEdit')->name('product.category.submit.edit');
            Route::post('/delete', 'Admin\ProductCategoryController@doDelete')->name('product.category.submit.delete');
        });

        Route::group(['prefix' => 'ship-type'], function () {
            Route::get('/list', 'Admin\ShipTypeController@index')->name('ship.type.list');
            Route::get('/add', 'Admin\ShipTypeController@add')->name('ship.type.add');
            Route::post('/add', 'Admin\ShipTypeController@doAdd')->name('ship.type.submit.add');
            Route::get('/edit/{id}', 'Admin\ShipTypeController@edit')->name('ship.type.edit');
            Route::post('/edit', 'Admin\ShipTypeController@doEdit')->name('ship.type.submit.edit');
            Route::post('/delete', 'Admin\ShipTypeController@doDelete')->name('ship.type.submit.delete');
        });

        Route::group(['prefix' => 'shop-info'], function () {
            Route::get('/list', 'Admin\ShopInfoController@index')->name('shop.info.list');
            Route::get('/add', 'Admin\ShopInfoController@add')->name('shop.info.add');
            Route::post('/add', 'Admin\ShopInfoController@doAdd')->name('shop.info.submit.add');
            Route::get('/edit/{id}', 'Admin\ShopInfoController@edit')->name('shop.info.edit');
            Route::post('/edit', 'Admin\ShopInfoController@doEdit')->name('shop.info.submit.edit');
            Route::post('/delete', 'Admin\ShopInfoController@doDelete')->name('shop.info.submit.delete');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/list', 'Admin\UserController@index')->name('user.list');
            Route::get('/add', 'Admin\UserController@add')->name('user.add');
            Route::post('/add', 'Admin\UserController@doAdd')->name('user.submit.add');
            Route::get('/edit/{id}', 'Admin\UserController@edit')->name('user.edit');
            Route::post('/edit', 'Admin\UserController@doEdit')->name('user.submit.edit');
            Route::post('/delete', 'Admin\UserController@doDelete')->name('user.submit.delete');
            Route::post('/unlock', 'Admin\UserController@doUnlock')->name('user.submit.unlock');
            Route::post('/lock', 'Admin\UserController@doLock')->name('user.submit.lock');
            Route::post('/reset', 'Admin\UserController@doReset')->name('user.submit.reset');
            Route::post('/change-language', 'Admin\UserController@doChangeLanguage')->name('user.submit.change.language');
        });


        Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
        Route::post('/logout', 'Auth\AdminLoginController@logout');
        Route::get('/login', 'Auth\AdminLoginController@getLogin')->name('admin.show');
        Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    });
});
