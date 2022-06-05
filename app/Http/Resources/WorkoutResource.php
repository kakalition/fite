<?php

namespace App\Http\Resources;

use App\Models\Exercise;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $exercise = Exercise::where('id', $this->exercise_id)->first();
    return [
      'exercise' => new ExerciseResource($exercise),
      'sets' => $this->sets
    ];
  }
}
