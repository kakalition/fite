<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'reps', 'weights_in_kg', 'duration_in_sec', 'rest'];
}
