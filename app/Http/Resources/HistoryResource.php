<?php

namespace App\Http\Resources;

use App\Models\SavedWorkout;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
  public function toArray($request)
  {
    $workout_name = SavedWorkout::where('id', $this->saved_workout_id)
      ->first()
      ->title;

    $unix_timestamp = strtotime($this->created_at);
    $dt = new DateTime();
    $dt->setTimestamp($unix_timestamp);
    $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
    $date = $dt->format('F/d/Y - H:i');

    return [
      'id' => $this->id,
      'workout_name' => $workout_name,
      'date' => $date
    ];
  }
}
