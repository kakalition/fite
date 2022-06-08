<?php

namespace App\Validators;

use App\Models\Exercise;
use App\Validators\Validation\RequestValidation;
use App\Validators\Validation\ValidationStatus;

class ExerciseValidator
{
  public function validate_duplication($user_id, $title, $type)
  {
    $found = Exercise::where('user_id', $user_id)
      ->where('title', $title)
      ->where('type', $type)
      ->get();

    if ($found->isNotEmpty()) {
      return new RequestValidation(ValidationStatus::Failed, 'Duplicated data.');
    }

    return new RequestValidation(ValidationStatus::Success);
  }
}
