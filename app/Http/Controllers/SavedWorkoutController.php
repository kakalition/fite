<?php

namespace App\Http\Controllers;

use App\Http\Resources\SavedWorkoutResource;
use App\Models\SavedWorkout;
use App\Models\User;
use Illuminate\Http\Request;
use App\Validator\SavedWorkoutValidator;

class SavedWorkoutController extends Controller
{

  public function index()
  {
    $saved_workouts = SavedWorkoutResource::collection(SavedWorkout::all());
    return response(SavedWorkout::all());
  }

  /* Exercises JSON Format
   * {
   *   exercise_id,
   *   reps,
   *   rest,
   * }
   */
  public function store(Request $request)
  {
    $validator = new SavedWorkoutValidator();
    $validation_status = $validator->validate($request);

    if ($validation_status != null) {
      return $validation_status;
    }

    $public_workout_id = $request->input('public_workout_id');
    $model = null;

    if ($public_workout_id != null) {
      $model = SavedWorkout::create([
        'user_id' => $request->input('user_id'),
        'title' => $request->input('title'),
        //'public_workout_id' => $public_workout_id,
      ]);
    } else {
      $model = SavedWorkout::create([
        'user_id' => $request->input('user_id'),
        'title' => $request->input('title'),
        'exercises' => json_encode($request->input('exercises')),
      ]);
    }

    return response(new SavedWorkoutResource($model));
  }

  public function show(User $user, $saved_workout)
  {
    $modifiedParam = str_replace('-', ' ', $saved_workout);
    $workout = $user
      ->saved_workouts
      ->filter(function ($value, $key) use ($modifiedParam) {
        return strtolower($value->title) == $modifiedParam;
      })
      ->first();

    if ($workout == null) {
      return response('Not found', 404);
    }

    return response(new SavedWorkoutResource($workout));
  }

  public function update(Request $request, SavedWorkout $savedWorkout)
  {
    //
  }

  public function destroy(SavedWorkout $saved_workout)
  {
    $saved_workout->delete();
    return response('', 204);
  }
}
