<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
Route::apiResources([
    'employees' => 'EmployeeController'
]);*/

//Route::get('/employees', 'EmployeeController@index');
Route::middleware('cors')->group(function(){
   Route::apiResources(
        ['employees' => 'EmployeeController',
         'positions' => 'PositionController',
         'stages' => 'StageController',  
         'seasons' => 'SeasonController',
         'performances' => 'PerformanceController',
         'seances' => 'SeanceController' 
        ]
	);	

});
