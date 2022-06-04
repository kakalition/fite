<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
  private function exercise_constraints_checker($type, $reps, $weights_in_kg, $durations_in_sec)
  {
    if ($type === 0 && $reps === null) {
      return response('Bodyweight training should include repetitions.', 400);
    }

    if ($type === 1 && ($reps === null || $weights_in_kg === null)) {
      return response('Weight training should include repetitions and weights.', 400);
    }

    if ($type === 2 && $durations_in_sec === null) {
      return response('Interval training should include durations.', 400);
    }

    if ($type < 0 || $type > 2) {
      return response('Exercise type not recognized.', 400);
    }

    return null;
  }
  public function index()
  {
    $exercises = ExerciseResource::collection(Exercise::all());
    return response($exercises);
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
    $durations_in_sec = $request->input('durations_in_sec');
    $rest = $request->input('rest');

    $model = null;

    $constraints_violation = $this->exercise_constraints_checker($type, $reps, $weights_in_kg, $durations_in_sec);
    if ($constraints_violation != null) {
      return $constraints_violation;
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
        'durations_in_sec' => $durations_in_sec,
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
    $title = $request->input('title') ?? $exercise;
    $type = $request->input('type') ?? $exercise;
    $reps = $type == 0 || $type == 1
      ? $request->input('reps') ?? $exercise->reps
      : null;
    $weights_in_kg = $type == 1
      ? $request->input('weights_in_kg') ?? $exercise->weights_in_kg
      : null;
    $durations_in_sec = $type == 2
      ? $request->input('durations_in_sec') ?? $exercise->duration_in_sec
      : null;
    $rest = $request->input('rest');

    $constraints_violation = $this->exercise_constraints_checker($type, $reps, $weights_in_kg, $durations_in_sec);
    if ($constraints_violation != null) {
      return $constraints_violation;
    }

    $exercise->update([
      'title' => $title,
      'type' => $type,
      'reps' => $reps,
      'weights_in_kg' => $weights_in_kg,
      'durations_in_sec' => $durations_in_sec,
      'rest' => $rest,
    ]);

    return response($exercise->toJson());
  }

  public function destroy(Exercise $exercise)
  {
    $exercise->delete();
    return response('', 204);
  }
}
