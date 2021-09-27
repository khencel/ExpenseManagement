<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if(auth()->user()){
        auth()->user()->assignRole('user');
    }
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('role')->group(function(){
    Route::get('index',function(){
        return view('user-management.role.index');
    });
});

Route::prefix('user')->group(function(){
    Route::get('index',function(){
        return view('user-management.user.index');
    });
});

Route::prefix('category')->group(function(){
    Route::get('index',function(){
        return view('expense-management.category.index');
    });
});

Route::prefix('expense')->group(function(){
    Route::get('index',function(){
        return view('expense-management.expenses.index');
    });
});

Route::get('change-password',function(){
    return view('changepassword');
});