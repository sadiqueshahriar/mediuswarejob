<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\withdrawController;
use App\Http\Controllers\Auth\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('store-user', [AuthController::class, 'store'])->name('store.user');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('deposit', DepositController::class);
Route::resource('withdrawal', withdrawController::class);
