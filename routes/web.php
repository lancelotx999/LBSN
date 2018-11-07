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
Route::post('/rating', 'RatingController@store');

// Resource Routes
Route::resource('business', 'BusinessController');
Route::resource('property', 'PropertyController');
Route::resource('contract', 'ContractController');

// Testing Routes
Route::resource('/test1', 'BusinessController@test');
Route::resource('/test2', 'PropertyController@test');
Route::resource('/test3', 'ContractController@test');
Route::resource('/test4', 'ReceiptController@test');
