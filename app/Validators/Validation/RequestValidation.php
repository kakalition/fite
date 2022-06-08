<?php

namespace App\Validators\Validation;

class RequestValidation
{
  public $status = null;
  public $message = null;

  public function __construct(ValidationStatus $status, $message = '')
  {
    $this->status = $status;
    $this->message = $message;
  }
}
