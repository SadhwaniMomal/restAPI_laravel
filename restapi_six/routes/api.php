<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
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
Route::get('/items' , [ItemController::class , 'index']);
Route::post('/items' , [ItemController::class , 'store']);
Route::get('/items/{id}' , [ItemController::class , 'show']);
Route::post('/items/{id}' , [ItemController::class , 'update']);
Route::post('/register' , [UserController::class , 'register']);
Route::post('/login' , [UserController::class , 'login']);


Route::group(['middleware' => ['auth:sanctum']] , function(){
    Route::delete('/items/{id}' , [ItemController::class , 'destroy']);
    Route::post('/logout' , [UserController::class , 'logout']);

});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
