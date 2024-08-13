<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
});

Route::group(['middleware' => 'api','prefix' => 'tasks'], function ($router) {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'create']);
    Route::get('/{taskId}', [TaskController::class, 'show']);
    Route::put('/{taskId}', [TaskController::class, 'complete']);
    Route::delete('/{taskId}', [TaskController::class, 'destroy']);
});
