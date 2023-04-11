<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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

Route::get('/',[IndexController::class,'index'])->name('index');
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('submitLogin',[LoginController::class, 'submitLogin'])->name('submitLogin');
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('submitRegister', [RegisterController::class, 'submitRegister'])->name('submitRegister');
Route::get('home', [IndexController::class, 'dashboard'])->name('home');
Route::get('logout', [IndexController::class, 'logout'])->name('logout');
