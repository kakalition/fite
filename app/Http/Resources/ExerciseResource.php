<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'type' => $this->type,
      'reps' => $this->whenNotNull($this->reps),
      'weights_in_kg' => $this->whenNotNull($this->weights_in_kg),
      'durations_in_sec' => $this->whenNotNull($this->durations_in_sec),
      'rest' => $this->whenNotNull($this->rest),
    ];
  }
}
