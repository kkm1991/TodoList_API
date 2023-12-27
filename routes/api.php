<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;

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
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->prefix('task')->group(function (){
    Route::get('list',[TasksController::class,'allTasks']);
    Route::post('add',[TasksController::class,'createTask']);
    Route::post('update',[TasksController::class,'updateTask']);
    Route::get('delete',[TasksController::class,'deleteTask']);
});
