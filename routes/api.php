<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAPIController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserAPIController::class, 'register']);
Route::post('/login', [UserAPIController::class, 'login']);
Route::post('/social-login', [UserAPIController::class, 'socialLogin']);

Route::middleware('auth:api')->group( function () {
    Route::get('home', [UserAPIController::class,'home']);
});