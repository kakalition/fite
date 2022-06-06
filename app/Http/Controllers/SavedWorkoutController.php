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

  private function exercise_constraints_checker($type, $reps, $weights_in_kg, $durations_in_sec)
  {
    if ($type === 0 && $reps === null) {
      return response('Bodyweight training should include repetitions.', 400);
    }

    if ($type === 1 && ($reps === null || $weights_in_kg === null)) {
      return response('Weight training should include repetitions and weights.', 400);
    }

    if ($type === 2 && $durations_in_sec === null) {
      return response('Interval training should include durations.', 400);
    }

    if ($type < 0 || $type > 2) {
      return response('Exercise type not recognized.', 400);
    }

    return null;
  }

  public function index()
  {
    $saved_workouts = SavedWorkoutResource::collection(SavedWorkout::all());
    return response($saved_workouts);
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
    $title = $request->input('title');
    $user_id = $request->input('user_id');
    $public_workout_id = $request->input('public_workout_id');
    $exercises = $request->input('exercises');

    $model = null;

    if ($public_workout_id != null && $exercises != null) {
      return response('Public workout id and exercises cannot exist at the same time.', 400);
    }

    foreach ($exercises as $exercise) {
      $_exercise = Exercise::where('id', $exercise['exercise_id'])
        ->first();

      $constraint_status = $this->exercise_constraints_checker(
        $_exercise->type,
        $exercise['reps'] ?? null,
        $exercise['weights_in_kg'] ?? null,
        $exercise['duration_in_sec'] ?? null,
      );

      if ($constraint_status != null) {
        return $constraint_status;
      }
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
        'exercises' => json_encode($exercises),
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
