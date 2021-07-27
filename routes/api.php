<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => ''], function () {
    
    Route::post('/categories/store', 'CategoryController@store')->name('admin.categories.store');
    Route::get('/categories/all', 'CategoryController@index')->name('admin.categories.all');
    Route::post('/items/store', 'ItemController@store')->name('admin.items.store');
    Route::get('/items/all', 'ItemController@index')->name('admin.items.all');
    Route::post('/order/create', 'OrdersController@addOrder')->name('admin.order.store');
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// Route::post('/register', [AuthController::class, 'register']);
