<?php

namespace App\Validators;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;

class SavedWorkoutValidator
{

  private function validate_title($user_id, $title)
  {
    $existing_titles = User::where('id', $user_id)
      ->first()
      ->saved_workouts
      ->filter(function ($value) use ($title) {
        return strtolower($value->title) == strtolower($title);
      });

    if ($existing_titles->count() > 0) {
      return response('Title already exists.', 400);
    }

    return null;
  }

  private function validate_exercise($exercise)
  {
    $is_reps_available = isset($exercise['reps']);
    $is_weights_available = isset($exercise['weights_in_kg']);
    $is_duration_available = isset($exercise['duration_in_sec']);

    $exercise_type = Exercise::where('id', $exercise['exercise_id'])
      ->first()
      ->type;

    if (
      $exercise_type == 0
      && ($is_reps_available ? $exercise['reps'] == null : true)
    ) {
      return response('Bodyweight training should include repetitions.', 400);
    }

    if (
      $exercise_type == 1
      && (($is_reps_available ? $exercise['reps'] == null : true)
        || ($is_weights_available ? $exercise['weights_in_kg'] == null : true))
    ) {
      return response('Weight training should include repetitions and weights.', 400);
    }

    if (
      $exercise_type == 2
      && ($is_duration_available ? $exercise['durations_in_sec'] == null : true)
    ) {
      return response('Interval training should include durations.', 400);
    }

    if (
      $exercise_type < 0
      || $exercise_type > 2
    ) {
      return response('Exercise type not recognized.', 400);
    }
  }

  private function validate_exclusivity($public_workout_id, $exercises)
  {
    if (
      $public_workout_id != null
      && $exercises != null
    ) {
      return response('Public workout id and exercises cannot exist at the same time.', 400);
    }

    return null;
  }

  public function validate(Request $request)
  {
    $existing_title_validation = $this->validate_title(
      $request->input('user_id'),
      $request->input('title'),
    );

    if ($existing_title_validation != null) {
      return $existing_title_validation;
    }

    $exclusivity_validation = $this->validate_exclusivity(
      $request->input('public_workout_id'),
      $request->input('exercises'),
    );

    if ($exclusivity_validation != null) {
      return $exclusivity_validation;
    }

    $exercise_validation = null;
    foreach ($request->input('exercises') as $exercise) {
      $exercise_validation = $this->validate_exercise($exercise);
      if ($exercise_validation != null) break;
    }

    if ($exercise_validation != null) {
      return $exercise_validation;
    }

    return null;
  }
}
