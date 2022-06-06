<?php

namespace App\Services;

use App\Http\Resources\SavedWorkoutResource;
use App\Models\SavedWorkout;
use App\Models\User;
use App\Validators\SavedWorkoutValidator;
use Illuminate\Http\Request;

class SavedWorkoutService
{
  public function get_saved_workouts(User $user)
  {
    $saved_workouts = $user->saved_workouts;
    return SavedWorkoutResource::collection($saved_workouts);
  }

  public function new_saved_workout(Request $request)
  {
    $validator = new SavedWorkoutValidator();
    $validation_status = $validator->validate($request);

    if ($validation_status != null) {
      return [
        'status' => 400,
        'data' => $validation_status,
      ];
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

    return [
      'status' => 201,
      'data' => $model,
    ];
  }

  public function find_workout(User $user, $slug)
  {
    $modified_slug = str_replace('-', ' ', $slug);
    $workout = $user
      ->saved_workouts
      ->filter(function ($value) use ($modified_slug) {
        return strtolower($value->title) == $modified_slug;
      })
      ->first();

    return $workout;
  }

  public function delete_workout(User $user, $slug)
  {
    $workout = $this->find_workout($user, $slug);
    if ($workout != null) {
      $workout->delete();
      return true;
    } else return false;
  }
}
