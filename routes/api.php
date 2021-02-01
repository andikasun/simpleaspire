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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*Route::get('/users', function (Request $request) {

    return response()->json(['name' => 'My details']);

});*/

Route::middleware('auth:api')->get('/users', function (Request $request) {
    return response()->json(['name' => Auth::User()->name]);
});

Route::middleware('auth:api')->resource('/loan', 'App\Http\Controllers\LoanController');
Route::middleware('auth:api')->post('/payloan/{id}', 'App\Http\Controllers\LoanRepaymentController@payloan');
Route::middleware('auth:api')->post('/approveloan', 'App\Http\Controllers\LoanController@approveloan');