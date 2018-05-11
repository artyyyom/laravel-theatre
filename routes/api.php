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

Route::middleware('cors')->group(function(){
    Route::post('getUserTickets', 'TicketController@getUserTickets');
    Route::post('getUserActualSeances', 'SeanceController@getUserActualSeances');
    Route::post('getUserHistorySeances', 'SeanceController@getUserHistorySeances'); 
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::post('logout', 'UserController@logout');  
    Route::group(['middleware' => 'auth:api'], function(){
         Route::post('details', 'UserController@details');	
     });
   Route::apiResources(
        ['employees' => 'EmployeeController',
         'positions' => 'PositionController',
         'stages' => 'StageController',  
         'seasons' => 'SeasonController',
         'performances' => 'PerformanceController',
         'seances' => 'SeanceController',
         'units' => 'UnitController',
         'rows_places' => 'RowPlaceController',
         'tickets' => 'TicketController',
         'category_places' => 'CategoryPlaceController',
         'users' => 'UserController' 
        ]
   );
    

});
