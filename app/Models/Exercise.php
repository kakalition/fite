<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'repetitions', 'weights_in_kg', 'duration_in_sec', 'rest_in_sec'];
}
