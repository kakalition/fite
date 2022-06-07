<?php

namespace App\Http\Resources;

use App\Models\Exercise;
use App\Models\PublicWorkout;
use App\Models\SavedWorkout;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedWorkoutResource extends JsonResource
{
  private function exercises_mapper($res)
  {
    return array_map(function ($item) {
      $exercise = new ExerciseResource(
        Exercise::where('id', $item->exercise_id)->first()
      );

      $return_value = $exercise->toArray(null);
      if ($exercise->type == 0) {
        $return_value += array('reps' => $item->reps);
      } else if ($exercise->type == 1) {
        $return_value += array('reps' => $item->reps);
        $return_value += array('weights_in_kg' => $item->weights_in_kg);
      } else {
        $return_value += array('duration_in_sec' => $item->duration_in_sec);
      }

      $return_value += array('rest' =>  $item->rest);

      return $return_value;
    }, json_decode($res));
  }

  public function toArray($request)
  {
    $exercises = null;

    if ($this->exercises != null) {
      $exercises = $this->exercises_mapper($this->exercises);
    } else {
      $saved_id = PublicWorkout::where('id', $this->public_workout_id)
        ->first()
        ->saved_workout_id;
      $saved_exercises = SavedWorkout::where('id', $saved_id)
        ->first()
        ->exercises;

      $exercises = $this->exercises_mapper($saved_exercises);
    }

    return [
      'id' => $this->id,
      'title' => $this->title,
      'exercises' => $exercises,
    ];
  }
}
