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

// Edit profile
Route::resource('users', 'UserController');

Route::get('/allLocations', 'LocationController@allLocations');
Route::resource('location', 'LocationController');
Route::resource('contract', 'ContractController');
// Route::get('/createPropertyContract/{locationID}', 'PropertyContractController');
// Route::get('/propertyContract/create{id}',
//     [
//         'middleware' => 'auth',
//         'as' => 'propertyContract.create',
//         'uses' => 'PropertyContractController@create'
//     ]);
Route::resource('propertyContract', 'PropertyContractController');
Route::resource('serviceContract', 'ServiceContractController');
