<?php

namespace App\Validators;

use App\Models\PublicWorkout;
use App\Models\SavedWorkout;
use App\Validators\Validation\RequestValidation;
use App\Validators\Validation\ValidationStatus;
use Illuminate\Http\Request;

class PublicWorkoutValidator
{
  public function validate_duplication(Request $request): RequestValidation
  {
    $author_id = $request->input('author_id');
    $saved_workout_id = $request->input('saved_workout_id');

    $found = PublicWorkout::where('author_id', $author_id)
      ->where('saved_workout_id', $saved_workout_id)
      ->get();

    if ($found->isEmpty()) {
      return new RequestValidation(ValidationStatus::Success);
    }

    return new RequestValidation(
      ValidationStatus::Failed,
      'Duplicated value'
    );
  }

  public function validate_user_saved_duplication($user_id, $public_workout_id): RequestValidation
  {
    $found = SavedWorkout::where('user_id', $user_id)
      ->where('public_workout_id', $public_workout_id)
      ->get();

    if ($found->isEmpty()) {
      return new RequestValidation(
        ValidationStatus::Success,
      );
    }

    return new RequestValidation(
      ValidationStatus::Failed,
      'Duplicated saved workout.'
    );
  }
}
