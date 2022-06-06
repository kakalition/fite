<?php

namespace App\Http\Controllers;

use App\Http\Resources\SavedWorkoutResource;
use App\Models\SavedWorkout;
use App\Models\User;
use App\Services\SavedWorkoutService;
use Illuminate\Http\Request;

class SavedWorkoutController extends Controller
{
  protected $saved_workout_service;

  public function __construct(SavedWorkoutService $saved_workout_service)
  {
    $this->saved_workout_service = $saved_workout_service;
  }

  public function index(User $user)
  {
    $saved_workouts = $this
      ->saved_workout_service
      ->get_saved_workouts($user);
    return response($saved_workouts);
  }

  public function store(Request $request)
  {
    $save_status = $this
      ->saved_workout_service
      ->new_saved_workout($request);

    if ($save_status['status'] == 200) {
      return response(new SavedWorkoutResource($save_status['data']));
    } else {
      return $save_status['data'];
    }
  }

  public function show(User $user, $saved_workout)
  {
    $result = $this
      ->saved_workout_service
      ->find_workout($user, $saved_workout);

    if ($result == null) {
      return response('Not found', 404);
    }

    return response(new SavedWorkoutResource($result));
  }

  public function update(Request $request, SavedWorkout $savedWorkout)
  {
    //
  }

  public function destroy(User $user, $saved_workout)
  {
    $delete_status = $this
      ->saved_workout_service
      ->delete_workout($user, $saved_workout);

    if ($delete_status != true) {
      return response('Workout not found.', 404);
    }

    return response('', 204);
  }
}
