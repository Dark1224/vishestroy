<?php

Route::group(['prefix'  =>  'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');
        Route::get('categories', 'Admin\DashboarController@showCategories')->name('admin.dashboard.show.categories');
        Route::get('addcategories', 'Admin\DashboarController@addCategories')->name('admin.dashboard.add.categories');
        Route::post('addcategories', 'Admin\DashboarController@addCategories')->name('admin.dashboard.add.categories.post');
        Route::get('editcategories/{id}', 'Admin\DashboarController@editCategories')->name('admin.dashboard.edit.categories');
        Route::post('editcategories/{id}', 'Admin\DashboarController@editCategories')->name('admin.dashboard.edit.categories.post');
        Route::get('removecategories/{id}', 'Admin\DashboarController@removeCategories')->name('admin.dashboard.remove.categories');

        Route::get('products', 'Admin\DashboarController@showProducts')->name('admin.dashboard.show.products');
        Route::get('fields', 'Admin\DashboarController@showFields')->name('admin.dashboard.show.fields');
        Route::post('fields', 'Admin\DashboarController@getVals')->name('admin.dashboard.get.values');
        Route::get('addproduct', 'Admin\DashboarController@addProduct')->name('admin.dashboard.add.product');
        Route::post('addproduct', 'Admin\DashboarController@addProduct')->name('admin.dashboard.add.product.post');

        Route::get('editProduct/{id}', 'Admin\DashboarController@editProduct')->name('admin.dashboard.edit.product');
        Route::post('editProduct/{id}', 'Admin\DashboarController@editProduct')->name('admin.dashboard.edit.product.post');

        Route::get('removeProduct/{id}', 'Admin\DashboarController@removeProduct')->name('admin.dashboard.remove.product');

        Route::get('getAllImages', 'Admin\DashboarController@getAllImages');

        Route::post('uploadImage', 'Admin\DashboarController@uploadImage')->name('admin.dashboard.upload.image');
        Route::post('removeImage', 'Admin\DashboarController@removeImage')->name('admin.dashboard.removedImage.image');
    });

});
