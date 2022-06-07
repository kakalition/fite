<?php

namespace App\Validators\Validation;

class PublicWorkoutValidation
{
  public $status = null;
  public $message = null;

  public function __construct(ValidationStatus $status, $message = '')
  {
    $this->status = $status;
    $this->message = $message;
  }
}
