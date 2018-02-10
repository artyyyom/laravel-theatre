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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'NavbarController@getNavbars');

Route::get('/positions', 'PositionController@index');

Route::get('/employees', 'EmployeeController@index');
Route::get('/employees/{id}', 'EmployeeController@show');