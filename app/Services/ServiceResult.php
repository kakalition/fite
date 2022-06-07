<?php

namespace App\Services;

class ServiceResult
{
  public $status;
  public $data;

  public function __construct(ServiceStatus $status, $data)
  {
    $this->status = $status;
    $this->data = $data;
  }
}
