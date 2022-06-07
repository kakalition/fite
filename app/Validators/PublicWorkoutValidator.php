<?php

namespace App\Validators;

use App\Models\PublicWorkout;
use App\Validators\Validation\PublicWorkoutValidation;
use App\Validators\Validation\ValidationStatus;
use Illuminate\Http\Request;

class PublicWorkoutValidator
{
  public function validate_duplication(Request $request): PublicWorkoutValidation
  {
    $author_id = $request->input('author_id');
    $saved_workout_id = $request->input('saved_workout_id');

    $found = PublicWorkout::where('author_id', $author_id)
      ->where('saved_workout_id', $saved_workout_id)
      ->get();

    if ($found->isEmpty()) {
      return new PublicWorkoutValidation(ValidationStatus::Success);
    }

    return new PublicWorkoutValidation(
      ValidationStatus::Failed,
      'Duplicated value'
    );
  }
}
