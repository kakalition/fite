<?php

namespace App\Http\Controllers;

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

    return response($public_workouts);
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

  public function show(PublicWorkout $publicWorkout)
  {
    //
  }

  public function update(Request $request, PublicWorkout $publicWorkout)
  {
    //
  }

  public function destroy(PublicWorkout $publicWorkout)
  {
    //
  }
}
