<?php

namespace App\Services;

use App\Validators\ExeriseValidator;

class ExerciseService
{
  protected $validator;

  public function __construct(ExeriseValidator $validator)
  {
    $this->validator = $validator;
  }
}
