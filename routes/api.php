<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\CardsController;
use App\Http\Controllers\API\CategoriesController;
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

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [LoginController::class, 'logout']);
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('categories', CategoriesController::class)->except([ 
                                                        'edit', 
                                                        'create'
                                                    ]);

    Route::resource('cards', CardsController::class)->except([ 
                                                        'edit', 
                                                        'create'
                                                    ]);

    Route::post('cards/assign', [CardsController::class, 'assignCard']);
    Route::post('cards/return-card', [CardsController::class, 'returnCard']);
    Route::post('cards/return-all-cards', [CardsController::class, 'returnAllCards']);
});