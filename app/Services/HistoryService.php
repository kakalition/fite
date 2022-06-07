<?php

namespace App\Services;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryService
{
  public function create_history(Request $request, $user_id)
  {
    $history = History::create([
      'user_id' => $user_id,
      'saved_workout_id' => $request->input('saved_workout_id'),
    ]);

    return $history;
  }
}
