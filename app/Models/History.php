<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id', 'saved_workout_id'
  ];

  public function workout()
  {
    return $this->belongsTo(SavedWorkout::class, 'saved_workout_id');
  }
}
