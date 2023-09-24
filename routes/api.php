<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortenerController;

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

Route::get('/login',[AuthController::class,'AuthenticateUser'])->name('login');


Route::middleware('auth:api')->get('/post', [ShortenerController::class,'index']);

Route::middleware('auth:api')->post('/post', [ShortenerController::class,'store']);
Route::middleware('auth:api')->get('/post/{id}',[ShortenerController::class,'show']);
Route::middleware('auth:api')->put('/post/{id}',[ShortenerController::class,'update']);
Route::middleware('auth:api')->delete('/post/{id}',[ShortenerController::class,'destroy']);

