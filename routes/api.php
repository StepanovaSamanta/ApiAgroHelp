<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->controller(\App\Http\Controllers\UserController::class)->group(function (){
    Route::put('/user/update/{id}','update');
    Route::delete('/user/delete/{id}','destroy');
    Route::get('/user/{id}','show');
});

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::post('/user/register','create');
    Route::post('/user/login','login')->name('login');
    Route::get('/users/all','index');
});
