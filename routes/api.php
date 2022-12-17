<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\UserController;

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

Route::post('/login',[AuthController::class,'login']);


Route::group(['middleware' => ['auth:api']],function(){
    Route::prefix('panel')->group(function(){
        Route::get('/',[PanelController::class,'index']);
    });
    Route::prefix('task')->controller(TaskController::class)->group(function(){
        Route::post('/','store');
        Route::post('/assign','assign');
        Route::post('/confirm','confirm');
    });
    Route::prefix('user')->group(function(){
        Route::get('/all',[UserController::class,'index']);
    });
    Route::get('/logout',[AuthController::class,'logout']);
});



