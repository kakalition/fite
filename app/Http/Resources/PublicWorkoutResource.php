<?php

namespace App\Http\Resources;

use App\Helpers\DateParser;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicWorkoutResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'author_id' => $this->author_id,
      'saved_workout_id' => $this->saved_workout_id,
      'created_at' => DateParser::parse($this->created_at, 'Asia/Jakarta')
    ];
  }
}
