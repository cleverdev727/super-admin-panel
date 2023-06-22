<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController as AppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('{all}', [AppController::class, 'index'])->where('all', '^((?!api).)*')->name('index');