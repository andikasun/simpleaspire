<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware('auth')->get('/', function () {
    return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/loanapplication', [App\Http\Controllers\HomeController::class, 'applyloan'])->name('loanapplication');
Route::get('/loandetail/{id}', [App\Http\Controllers\HomeController::class, 'loandetail'])->name('loandetail');
Route::get('/approveloan', [App\Http\Controllers\AdminController::class, 'approveloan'])->name('approveloan');
