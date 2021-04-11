<?php

use App\Http\Controllers\Api\Auth\AuthController;
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
Route::namespace('Api')->group(function () {
    Route::get('/index', 'Api/TestController@index');

    Route::namespace('Auth')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthController::class, 'login']);
            Route::post('registration',  [AuthController::class, 'registration']);
        });

    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
//Route::apiResources(
//    [
//        'user' => 'API\UserController'
//    ]
//  );
});
