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

// Resource Routes
Route::resource('business', 'BusinessController');
Route::resource('property', 'PropertyController');
Route::resource('contract', 'ContractController');
Route::resource('review', 'ReviewController');

// Testing Routes
Route::resource('/test1', 'BusinessController@test');
Route::resource('/test2', 'PropertyController@test');
Route::resource('/test3', 'ContractController@test');
Route::get('/test4', 'PDF_GeneratorController@invoiceGenerator');
Route::get('/test5', 'PDF_GeneratorController@receiptGenerator');
Route::get('/test6', 'PDF_GeneratorController@test');

