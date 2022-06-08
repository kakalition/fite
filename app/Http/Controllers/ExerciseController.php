<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{

  public function index()
  {
    $exercises = ExerciseResource::collection(Exercise::all());
    return response($exercises);
  }

  public function store(Request $request)
  {
    $title = $request->input('title');
    $type = $request->input('type');

    $model = Exercise::create([
      'title' => $title,
      'type' => $type,
    ]);

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

    $exercise->update([
      'title' => $title,
      'type' => $type,
    ]);

    return response($exercise->toJson());
  }

  public function destroy(Exercise $exercise)
  {
    $exercise->delete();
    return response('', 204);
  }
}
