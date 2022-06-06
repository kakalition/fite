<?php

namespace App\Http\Controllers;

use App\Http\Resources\SavedWorkoutResource;
use App\Models\Exercise;
use App\Models\SavedWorkout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavedWorkoutController extends Controller
{
  public function index()
  {
    $saved_workouts = SavedWorkoutResource::collection(SavedWorkout::all());
    return response($saved_workouts);
  }

  public function store(Request $request)
  {
    $title = $request->input('title');
    $user_id = $request->input('user_id');
    $public_workout_id = $request->input('public_workout_id');
    $exercises = json_encode($request->input('exercises'));

    $model = null;

    if ($public_workout_id != null && $exercises != null) {
      return response('Public workout id and exercises cannot exist at the same time.', 400);
    }

    if ($public_workout_id != null) {
      $model = SavedWorkout::create([
        'user_id' => $user_id,
        'title' => $title,
        //'public_workout_id' => $public_workout_id,
      ]);
    } else {
      $model = SavedWorkout::create([
        'user_id' => $user_id,
        'title' => $title,
        'exercises' => $exercises,
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
