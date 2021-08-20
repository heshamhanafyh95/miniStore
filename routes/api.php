<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return response()->json(Auth::user()->has_permission("get_item"), 200);
});


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => ''], function () {

    /*===================================================================================================*/
    /*=====================================   Categories Routes   =======================================*/
    /*===================================================================================================*/
    Route::get('/categories/all', 'CategoryController@index');
    Route::get('/categories/show', 'CategoryController@show');
    Route::post('/categories/store', 'CategoryController@store');
    Route::post('/categories/update', 'CategoryController@update');
    Route::post('/categories/delete', 'CategoryController@delete');

    /*===================================================================================================*/
    /*=====================================   items Routes   =======================================*/
    /*===================================================================================================*/
    Route::get('/items/all', 'ItemController@index')->middleware('checkPermissions:get_item');
    Route::get('/items/show', 'ItemController@show');
    Route::post('/items/store', 'ItemController@store');
    Route::post('/items/update', 'ItemController@update');
    Route::post('/items/delete', 'ItemController@delete');

    /*===================================================================================================*/
    /*                                        Orders Routes                                              */
    /*===================================================================================================*/
    Route::post('/order/create', 'OrdersController@addOrder');

    /*===================================================================================================*/
    /*                                        Roles Routes                                              */
    /*===================================================================================================*/
    Route::post('/role/create', 'RoleController@store');
});

/*===================================================================================================*/
/*                                        Auth Routes                                              */
/*===================================================================================================*/
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// Route::post('/register', [AuthController::class, 'register']);
