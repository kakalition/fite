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

    //dd(json_decode($this->exercises)['0']->reps);
    $exercises = array_map(function ($item) {
      //dd($item->reps);
      $exercise = new ExerciseResource(
        Exercise::where('id', $item->exercise_id)->first()
      );

      $return_value = $exercise->toArray(null);

      if ($exercise->type == 0) {
        $return_value += array('reps' =>  $item->reps);
      } else if ($exercise->type == 1) {
        $return_value += array('reps' =>  $item->reps);
        $return_value += array('weights_in_kg' =>  $item->weights_in_kg);
      } else {
        $return_value += array('duration_in_sec' =>  $item->duration_in_sec);
      }

      $return_value += array('rest' =>  $item->rest);

      return $return_value;
    }, json_decode($this->exercises));

    return [
      'id' => $this->id,
      'title' => $this->title,
      'exercises' => $exercises,
    ];
  }
}
