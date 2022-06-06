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
      $exercise = new ExerciseResource(
        Exercise::where('id', $item->exercise_id)->first()
      );

      $return_value = $exercise->toArray(null);
      $return_value += array('sets' =>  $item->sets);
      $return_value += array('rest_per_set' =>  $item->rest_per_set);

      return $return_value;
    }, json_decode($this->exercises));

    return [
      'id' => $this->id,
      'title' => $this->title,
      'exercises' => $exercises,
    ];
  }
}
