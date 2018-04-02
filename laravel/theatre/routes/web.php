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
// get navigation menu
Route::get('/navbars', 'NavbarController@index');

// get positions
Route::get('/positions', 'PositionController@index');

// get employees
Route::get('/employees', 'EmployeeController@getAll');
Route::get('/employee/{id}', 'EmployeeController@getOne');
Route::get('/employees/{id}', 'EmployeeController@getOneProfession');

// get performances
Route::get('/performances', 'PerformanceController@index');
Route::get('/performance/{id}', 'PerformanceController@show');

Route::get('/rowplace/{id}', 'RowPlaceController@show');
