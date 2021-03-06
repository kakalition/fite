<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicWorkoutResource;
use App\Models\PublicWorkout;
use App\Services\PublicWorkoutService;
use App\Services\ServiceStatus;
use Illuminate\Http\Request;

class PublicWorkoutController extends Controller
{
  protected $service;

  public function __construct(PublicWorkoutService $service)
  {
    $this->service = $service;
  }

  public function index()
  {
    $public_workouts = $this
      ->service
      ->get_public_workouts();

    return response(PublicWorkoutResource::collection($public_workouts), 201);
  }

  public function store(Request $request)
  {
    $public_workout = $this
      ->service
      ->create_public_workout($request);

    if ($public_workout->status == ServiceStatus::Failed) {
      return response($public_workout->data, 400);
    }

    return response($public_workout->data, 201);
  }

  public function show(PublicWorkout $public_workout)
  {
    return response($public_workout);
  }

  public function destroy($user_id, $public_workout_id)
  {
    $this
      ->service
      ->delete_public_workout($user_id, $public_workout_id);

    return response('', 204);
  }

  public function save_to_user($user_id, $public_workout_id)
  {
    $saved_workout = $this
      ->service
      ->save_to_user($user_id, $public_workout_id);

    if ($saved_workout->status == ServiceStatus::Failed) {
      return response($saved_workout->data, 400);
    }

    return response($saved_workout->data, 201);
  }
}
