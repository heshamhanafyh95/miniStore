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
    return response()->json(Auth::user()->has_permission("get_item"), 200);
});


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => ''], function () {

    /*===================================================================================================*/
    /*=====================================   Categories Routes   =======================================*/
    /*===================================================================================================*/
    Route::get('/categories/all', 'CategoryController@index')->name('admin.categories.all');
    Route::post('/categories/store', 'CategoryController@store')->name('admin.categories.store');

    /*===================================================================================================*/
    /*=====================================   items Routes   =======================================*/
    /*===================================================================================================*/
    Route::get('/items/all', 'ItemController@index')->name('admin.items.all')->middleware('checkPermissions:get_item');
    Route::post('/items/store', 'ItemController@store')->name('admin.items.store');

    /*===================================================================================================*/
    /*                                        Orders Routes                                              */
    /*===================================================================================================*/
    Route::post('/order/create', 'OrdersController@addOrder')->name('admin.order.store');

    /*===================================================================================================*/
    /*                                        Roles Routes                                              */
    /*===================================================================================================*/
});
Route::post('/role/create', 'RoleController@store')->name('admin.role.store');

/*===================================================================================================*/
/*                                        Auth Routes                                              */
/*===================================================================================================*/
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// Route::post('/register', [AuthController::class, 'register']);
