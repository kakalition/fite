<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use App\Services\ExerciseService;
use App\Services\ServiceStatus;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{

  protected $service;

  public function __construct(ExerciseService $service)
  {
    $this->service = $service;
  }

  public function index()
  {
    $exercises = ExerciseResource::collection(Exercise::all());
    return response($exercises);
  }

  public function store(Request $request, $user_id)
  {
    $result = $this
      ->service
      ->create_exercise($request, $user_id);

    if ($result->status == ServiceStatus::Failed) {
      return response($result->data, 201);
    }

    return response(new ExerciseResource($result->data), 201);
  }

  public function show(Exercise $exercise)
  {
    return new ExerciseResource($exercise);
  }

  public function update(Request $request, $user_id, $exercise_id)
  {
    $result = $this
      ->service
      ->update_exercise($request, $user_id, $exercise_id);

    if ($result->status == ServiceStatus::Failed) {
      return response($result->data, 200);
    }

    return response(new ExerciseResource($result->data), 200);
  }

  public function destroy($user_id, $exercise_id)
  {
    $this
      ->service
      ->delete_exercise($user_id, $exercise_id);

    return response('', 204);
  }
}
