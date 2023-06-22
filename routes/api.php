<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController as AuthController;

Route::group(['prefix' => 'auth'], static function() {
  Route::post('login', [AuthController::class, 'login'])->name('auth.login');
  Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
  Route::post('register', [AuthController::class, 'register'])->name('auth.register');
  Route::post('user', [AuthController::class, 'user'])->name('auth.user');
  Route::post('check', [AuthController::class, 'check'])->name('auth.check');
});