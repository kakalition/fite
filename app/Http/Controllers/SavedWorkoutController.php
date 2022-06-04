<?php

namespace App\Http\Controllers;

use App\Http\Resources\SavedWorkoutResource;
use App\Models\Exercise;
use App\Models\SavedWorkout;
use Illuminate\Http\Request;

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
    $exercises_id = $request->input('exercises');
    $exercises = collect();
    foreach ($exercises_id as $id) {
      $exercises->push(Exercise::where('id', $id));
    }

    $model = null;

    if ($public_workout_id != null && $exercises_id != null) {
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

  public function show(SavedWorkout $savedWorkout)
  {
    //
  }

  public function update(Request $request, SavedWorkout $savedWorkout)
  {
    //
  }

  public function destroy(SavedWorkout $savedWorkout)
  {
    //
  }
}
