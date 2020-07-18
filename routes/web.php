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
Auth::routes();
require 'admin.php';
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', 'HomeController@index', 'home');
Route::get('/get_product/{id}', 'ProductController@get_product');
Route::post('/add_product_to_bitrix', 'ProductController@add_product_to_bitrix');
Route::get('/category/{id}', 'CategoryController@get_category');
Route::get('/product/{id}', 'ProductController@product_page');
Route::get('/agreement', 'PagesController@agreement_page');
Route::get('/payment', 'PagesController@payment');
Route::get('/about-delivery', 'PagesController@about_delivery');

Route::get('/comparison', 'UserController@comparison_page');
Route::get('/pay', 'PagesController@pay');
Route::get('/cart', 'UserController@cart_page');
Route::get('/wishlist', 'UserController@wishlist_page');
Route::post('/filter', 'CategoryController@filter_products');

Route::match(['get', 'post'], '/getAllFromCache', 'UserController@getAllFromCache');

Route::match(['get', 'post'], '/addReview', 'ProductController@addReview');


Route::match(['get', 'post'], '/addRate', 'ProductController@addRate');

Route::match(['get', 'post'], '/searchProduct', 'ProductController@searchProduct');


Route::match(['get', 'post'], '/removeFromCart', 'UserController@removeFromCart');

Route::match(['get', 'post'], '/removeFromComparison', 'UserController@removeFromComparison');

Route::match(['get', 'post'], '/removeFromWishlist', 'UserController@removeFromWishlist');

Route::match(['get', 'post'], '/addToCart', 'UserController@addToCart');

Route::match(['get', 'post'], '/addToWhishList', 'UserController@addToWhishList');

Route::match(['get', 'post'], '/addToComparison', 'UserController@addToComparison');
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
Route::get('/about_us', 'PagesController@getAbout' );
Route::get('/bestseller', 'PagesController@getBestsellerPage' );
Route::get('/sel_lout', 'PagesController@getSelLoutPage' );
Route::get('/new', 'PagesController@getNewPage' );

Route::get('/personalArea', 'UserController@getPersonalPage')->middleware('auth');
Route::get('/checkout', 'PagesController@getCheckoutPage');
Route::get('/delivery', 'PagesController@getDeliveryPage');
Route::get('/end', 'PagesController@getEndPage');
Route::post('/addProductsToSession', 'PagesController@addProductsToSession');
Route::post('/getOrderByUid', 'UserController@getOrderByUid');
Route::post('/addDeliveryToSession', 'PagesController@addDeliveryToSession');
Route::post('/addInfoToSession', 'PagesController@addInfoToSession');
Route::get('/our-contacts', 'PagesController@ourContacts');
Route::get('/success', 'PagesController@success');

Route::post('/saveConfig', 'UserController@saveConfig')->middleware('auth');
Route::post('/getMaxPrice', 'PagesController@getMaxPrice');

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
