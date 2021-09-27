<?php

use Illuminate\Http\Request;
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
    return $request->user();
});


Route::middleware('auth:api')->group(function(){
    // role
    Route::prefix('role')->group(function(){
        Route::get('index',[App\Http\Controllers\API\UserManagement\RoleController::class,'index']);
        Route::post('store',[App\Http\Controllers\API\UserManagement\RoleController::class,'store']);
        Route::get('show/{id}',[App\Http\Controllers\API\UserManagement\RoleController::class,'show']);
        Route::put('update/{id}',[App\Http\Controllers\API\UserManagement\RoleController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\UserManagement\RoleController::class,'delete']);
    });

    //category
    Route::prefix('category')->group(function(){
        Route::get('index',[App\Http\Controllers\API\ExpenseManagement\CategoryController::class,'index']);
        Route::post('store',[App\Http\Controllers\API\ExpenseManagement\CategoryController::class,'store']);
        Route::get('show/{id}',[App\Http\Controllers\API\ExpenseManagement\CategoryController::class,'show']);
        Route::put('update/{id}',[App\Http\Controllers\API\ExpenseManagement\CategoryController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\ExpenseManagement\CategoryController::class,'destroy']);
    });

    //expense
    Route::prefix('expense')->group(function(){
        Route::get('index',[App\Http\Controllers\API\ExpenseManagement\ExpenseController::class,'index']);
        Route::post('store',[App\Http\Controllers\API\ExpenseManagement\ExpenseController::class,'store']);
        Route::get('show/{id}',[App\Http\Controllers\API\ExpenseManagement\ExpenseController::class,'show']);
        Route::put('update/{id}',[App\Http\Controllers\API\ExpenseManagement\ExpenseController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\ExpenseManagement\ExpenseController::class,'destroy']);
    });

    Route::get('home',[App\Http\Controllers\API\HomeController::class,'getExpenseSummary']);

    Route::post('change-password',[App\Http\Controllers\API\ChangePassword::class,'changePassword']);
    Route::post('password-change',[App\Http\Controllers\API\ChangePassword::class,'passwordChange']);
});

 // user

 Route::prefix('user')->group(function(){
    Route::get('index',[App\Http\Controllers\API\UserManagement\UserController::class,'index']);
    Route::post('store',[App\Http\Controllers\API\UserManagement\UserController::class,'store']);
    Route::get('show/{id}',[App\Http\Controllers\API\UserManagement\UserController::class,'show']);
    Route::put('update/{id}',[App\Http\Controllers\API\UserManagement\UserController::class,'update']);
    Route::delete('delete/{id}',[App\Http\Controllers\API\UserManagement\UserController::class,'delete']);
});









