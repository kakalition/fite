<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
  public function index()
  {
  }

  // Type 0: Bodyweight
  // Type 1: Weight Training
  // Type 2: Interval
  public function store(Request $request)
  {
    $title = $request->input('title');
    $type = $request->input('type');
    $reps = $request->input('reps');
    $weights_in_kg = $request->input('weights_in_kg');
    $duration_in_sec = $request->input('duration_in_sec');
    $rest = $request->input('rest');

    $model = null;

    if ($type === 0 && $reps === null) {
      return response('Bodyweight training should include repetitions.', 400);
    }

    if ($type === 1 && ($reps === null || $weights_in_kg === null)) {
      return response('Weight training should include repetitions and weights.', 400);
    }

    if ($type === 2 && $duration_in_sec === null) {
      return response('Interval training should include durations.', 400);
    }

    // Bodyweight Training
    if ($type === 0) {
      $model = Exercise::create([
        'title' => $title,
        'type' => $type,
        'reps' => $reps,
        'rest' => $rest
      ]);
    }

    // Weight Training
    else if ($type === 1) {
      $model = Exercise::create([
        'title' => $title,
        'type' => $type,
        'reps' => $reps,
        'weights_in_kg' => $weights_in_kg,
        'rest' => $rest
      ]);
    }

    // Interval Training
    else {
      $model = Exercise::create([
        'title' => $title,
        'type' => $type,
        'durations_in_sec' => $duration_in_sec,
        'rest' => $rest
      ]);
    }

    return response($model->toJson(), 201);
  }

  public function show(Exercise $exercise)
  {
    return new ExerciseResource($exercise);
  }

  public function update(Request $request, Exercise $exercise)
  {
    //
  }

  public function destroy(Exercise $exercise)
  {
    //
  }
}
