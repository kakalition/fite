<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SavedWorkoutController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::apiResources([
  'exercises' => ExerciseController::class,
  'users/{user}/saved-workouts' => SavedWorkoutController::class,
]);

Route::apiResource('users/{user}/histories', HistoryController::class)
  ->except('update');

Route::delete('users/{user}/histories', [HistoryController::class, 'destroy_all']);
