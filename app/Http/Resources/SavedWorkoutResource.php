<?php

namespace App\Http\Resources;

use App\Models\Exercise;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedWorkoutResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $exercises = array_map(function ($item) {
      $exercise = Exercise::where('id', $item->exercise_id)->first();
      return [
        'exercise' => new ExerciseResource($exercise),
        'sets' => $item->sets
      ];
    }, json_decode($this->exercises));

    return [
      'id' => $this->id,
      'title' => $this->title,
      'exercises' => $exercises,
    ];
  }
}
