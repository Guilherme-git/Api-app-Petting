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

//Link com o storage--------------
Route::get('storage-link',function (){
    return \Illuminate\Support\Facades\Artisan::call('storage:link');
});
//--------------------------------------

Route::post('auth/login', [\App\Http\Controllers\Auth::class, 'login']);
Route::get('auth/me', [\App\Http\Controllers\Auth::class, 'me']);

Route::post('user/create', [\App\Http\Controllers\UserController::class, 'create']);

Route::group(['middleware' => ['jwt']], function () {

    Route::prefix('user')->group(function () {
        Route::get('list-all',[\App\Http\Controllers\UserController::class,'listAll']);
        Route::put('edit-profile',[\App\Http\Controllers\UserController::class,'editProfile']);
        Route::post('edit-image-profile',[\App\Http\Controllers\UserController::class,'editImageProfile']);
        Route::post('edit/{id}',[\App\Http\Controllers\UserController::class,'edit']);

        Route::prefix('client')->group(function () {
            Route::post('create', [\App\Http\Controllers\ClientController::class, 'create']);
            Route::get('list', [\App\Http\Controllers\ClientController::class, 'list']);
            Route::get('list-all', [\App\Http\Controllers\ClientController::class, 'listAll']);
            Route::post('edit-image-animal', [\App\Http\Controllers\ClientController::class, 'editImageAnimal']);
        });

        Route::prefix('plain')->group(function () {
            Route::post('create', [\App\Http\Controllers\PlainController::class, 'create']);
            Route::get('list', [\App\Http\Controllers\PlainController::class, 'list']);
            Route::put('edit-value', [\App\Http\Controllers\PlainController::class, 'editValue']);
        });

        Route::prefix('tour')->group(function () {
            Route::post('create', [\App\Http\Controllers\TourController::class, 'create']);
            Route::get('list', [\App\Http\Controllers\TourController::class, 'list']);
            Route::get('list-all', [\App\Http\Controllers\TourController::class, 'listAll']);
        });


    });
});
