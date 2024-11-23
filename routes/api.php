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

Route::post("/users/register",[App\Http\Controllers\UserController::class,"registerUser"]);
Route::post("/users/login",[App\Http\Controllers\UserController::class,"login"]);

Route::middleware(App\Http\Middleware\AuthorizeMiddleware::class)->group(function()
{
    Route::post("/users/get",[App\Http\Controllers\UserController::class,"get"]);
});
