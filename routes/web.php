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

Route::view('/', 'home');

Route::view('/map', 'map');

Route::view('/welcome', 'welcome');

Auth::routes();

// User profile
Route::resource('users', 'UserController');
Route::get('/users/{user}/contract', 'UserController@getContract')->name('users.contract');

Route::get('/property/listing', 'PropertyController@showAll');
Route::post('/rating/store', 'RatingController@store');
Route::post('/review/store', 'ReviewController@store');
Route::get('/transaction/create/{id}',
    [
        'middleware' => 'auth',
        'as' => 'transaction.create',
        'uses' => 'TransactionController@create'
    ]);

// Resource Routes
Route::resource('business', 'BusinessController');
Route::resource('property', 'PropertyController');
Route::resource('contract', 'ContractController');
Route::resource('review', 'ReviewController');
Route::resource('transaction', 'TransactionController');
Route::resource('invoice', 'InvoiceController');
Route::resource('conversations', 'ConversationController');

// Testing Routes
Route::get('/test1', 'ReceiptController@test');
Route::get('/test2', 'InvoiceController@test');
Route::get('/test3', 'ContractController@test');
Route::get('/test4', 'PDF_GeneratorController@invoiceGenerator');
Route::get('/test5', 'PDF_GeneratorController@receiptGenerator');
Route::get('/test6', 'PDF_GeneratorController@test');
Route::get('/test7', 'SearchController@test');
