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

Route::get('/', 'UserController@home')->name('home');

Auth::routes();

// User profile
Route::resource('user', 'UserController');
Route::get('/user/{user}/contract', 'UserController@getContract')->name('users.contract');

Route::get('/property/listing', 'PropertyController@showAll');
Route::get('/business/listing', 'BusinessController@showAll');
Route::post('/rating/store', 'RatingController@store');
Route::post('/review/store', 'ReviewController@store');
Route::get('/transaction/create/{id}',
    [
        'middleware' => 'auth',
        'as' => 'transaction.create',
        'uses' => 'TransactionController@create'
    ]);

Route::get('/invoice/create/{id}',
    [
        'middleware' => 'auth',
        'as' => 'invoice.create',
        'uses' => 'InvoiceController@create'
    ]);

Route::get('/contract/create/{id}',
    [
        'middleware' => 'auth',
        'as' => 'contract.create',
        'uses' => 'ContractController@create'
    ]);

Route::get('/transaction/receipt/{id}', 'PDF_GeneratorController@invoiceGenerator');

// Search Routes
Route::post('/property/search', 'SearchController@searchProperties')->name('property.search');
Route::post('/business/search', 'SearchController@searchBusinesses')->name('business.search');

// Resource Routes
Route::resource('business', 'BusinessController');
Route::resource('property', 'PropertyController');
Route::resource('contract', 'ContractController');
Route::resource('review', 'ReviewController');
Route::resource('transaction', 'TransactionController');
Route::resource('invoice', 'InvoiceController');
Route::resource('conversation', 'ConversationController');

// Testing Routes
Route::get('/test1', 'ReceiptController@test');
Route::get('/test2', 'InvoiceController@test');
Route::get('/test3', 'ContractController@test');
Route::get('/test4', 'PDF_GeneratorController@invoiceGenerator');
Route::get('/test5', 'PDF_GeneratorController@receiptGenerator');
Route::get('/test6', 'PDF_GeneratorController@test');

Route::view('/payment', 'ePayment/payment');
Route::get('/test7', 'ePaymentController@process')->name('payment.process');
Route::get('/test7', 'SearchController@test');
Route::get('/test8', 'ConversationController@notificationTest');
Route::get('/test1', 'BusinessController@test');
Route::get('/test2', 'UserController@test');
Route::get('/test3', 'PropertyController@test');

