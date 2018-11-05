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

// Resource Routes
Route::resource('business', 'BusinessController');
Route::resource('property', 'PropertyController');
Route::resource('contract', 'ContractController');

// Testing Routes
Route::get('/test1', 'BusinessController@test');
Route::get('/test2', 'ContractController@test');
Route::get('/test3', 'PropertyController@test');
Route::get('/test4', 'RatingController@test');
Route::get('/test5', 'ReceiptController@test');
Route::get('/test6', 'ReviewController@test');
Route::get('/test7', 'UserController@test');