<?php

namespace App\Http\Resources;

use App\Models\SavedWorkout;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedHistoryResource extends JsonResource
{
  public function toArray($request)
  {
    $saved_workout = SavedWorkout::where('id', $this->saved_workout_id)
      ->first();

    $workout = new SavedWorkoutResource($saved_workout);

    $unix_timestamp = strtotime($this->created_at);
    $dt = new DateTime();
    $dt->setTimestamp($unix_timestamp);
    $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
    $date = $dt->format('F/d/Y - H:i');

    return [
      'id' => $this->id,
      'workout' => $workout,
      'date' => $date
    ];
  }
}
