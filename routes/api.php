<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;

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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/getData',[DataController::class, 'getData']);
Route::put('/update/{id}',[DataController::class, 'update']);
Route::delete('/delete/{id}',[DataController::class, 'delete']);
Route::post('/insertData', [DataController::class, 'insertData']);

 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
