<?php

namespace App\Services;

use App\Models\PublicWorkout;
use App\Validators\PublicWorkoutValidator;
use App\Validators\Validation\PublicWorkoutValidation;
use App\Validators\Validation\ValidationStatus;
use Illuminate\Http\Request;

class PublicWorkoutService
{
  protected $validator;

  public function __construct(PublicWorkoutValidator $validator)
  {
    $this->validator = $validator;
  }

  public function get_public_workouts()
  {
    $public_workouts = PublicWorkout::all();
    return $public_workouts;
  }

  public function create_public_workout(Request $request)
  {
    $public_workout = null;
    $validation = $this
      ->validator
      ->validate_duplication($request);

    if ($validation->status == ValidationStatus::Failed) {
      return new ServiceResult(ServiceStatus::Failed, $validation->message);
    }

    $public_workout = PublicWorkout::create([
      'author_id' => $request->input('author_id'),
      'saved_workout_id' => $request->input('saved_workout_id'),
    ]);

    return new ServiceResult(ServiceStatus::Success, $public_workout);
  }
}
