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

  public function delete_history($user_id, $history_id)
  {
    History::where('user_id', $user_id)
      ->where('id', $history_id)
      ->delete();
  }

  public function delete_histories($user_id)
  {
    History::where('user_id', $user_id)
      ->delete();
    return response('', 204);
  }
}
