<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskController;

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

Route::post('/sanctum/token', TokenController::class);

Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/users/auth', AuthController::class);
  Route::get('/users/{user}', [UserController::class, 'show']);
  Route::get('/users', [UserController::class, 'index']);
  Route::post('/users/auth/avatar', [AvatarController::class, 'store']);

  Route::resource('messages', MessageController::class);
  Route::get('/task_lists/one_hour_stat/{id}', [TaskListController::class, 'getLastOneHourTaskStatistic']);
  Route::resource('task_lists', TaskListController::class);
  Route::post('/tasks/set_done/{id}/{value}', [TaskController::class, 'setDone']);  // /{id} {value}
  Route::post('/tasks/set_done2', [TaskController::class, 'setDone2']);
  Route::resource('tasks', TaskController::class);
  

});
