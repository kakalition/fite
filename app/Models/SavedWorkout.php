<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedWorkout extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id', 
    'title', 
    //'public_workout_id', 
    'exercises'
  ];
}
