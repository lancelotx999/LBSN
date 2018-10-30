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

// Invoice
Route::resource('invoice', 'InvoiceController');
Route::get('/userid', 'InvoiceController@getCurrentUserRole');

// Contracts
Route::get('/allLocations', 'LocationController@allLocations');
Route::resource('location', 'LocationController');
Route::resource('contract', 'ContractController');
Route::resource('propertyContract', 'PropertyContractController');
Route::resource('serviceContract', 'ServiceContractController');

// Messenger
Route::get('tests', 'MessageController@tests');
Route::get('message/{id}', 'MessageController@chatHistory')->name('message.read');
Route::group(['prefix'=>'ajax', 'as'=>'ajax::'], function() {
   Route::post('message/send', 'MessageController@ajaxSendMessage')->name('message.new');
   Route::delete('message/delete/{id}', 'MessageController@ajaxDeleteMessage')->name('message.delete');
});

Route::get('/sinvoice', 'InvoiceController@store');
Route::get('/showinvoice', 'InvoiceController@show');


