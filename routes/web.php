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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() { // this middleware for only auth or not.
    Route::resource('articles', App\Http\Controllers\ArticleController::class);
    Route::view('invite','invite')->name('invite');
    

    //* The mistake happens every time if you dont add App\Http\Controllers prefix.
    Route::get('join','App\Http\Controllers\JoinController@create')->name('join.create');
    Route::post('join','App\Http\Controllers\JoinController@store')->name('join.store');

    Route::get('organization/{organization_id}','App\Http\Controllers\JoinController@organizations')->name('organization');

    // I created new middleware in app\controllers\Middleware -> IsAdminMiddleware / then I used it to protect this route.
    Route::group(['middleware'=>'is_admin'],function(){
    Route::resource('categories', App\Http\Controllers\CategoryController::class); 
    });
    
});
