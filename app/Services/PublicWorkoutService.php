<?php

namespace App\Services;

use App\Models\PublicWorkout;
use App\Models\SavedWorkout;
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

  public function save_to_user($user_id, $public_workout_id)
  {
    $validation = $this
      ->validator
      ->validate_user_saved_duplication($user_id, $public_workout_id);

    if ($validation->status == ValidationStatus::Failed) {
      return new ServiceResult(ServiceStatus::Failed, $validation->message);
    }

    $saved_id = PublicWorkout::where('id', $public_workout_id)
      ->first()
      ->saved_workout_id;
    $title = SavedWorkout::where('id', $saved_id)
      ->first()
      ->title;

    $saved_workout = SavedWorkout::create([
      'user_id' => $user_id,
      'title' => $title,
      'public_workout_id' => $public_workout_id
    ]);

    return new ServiceResult(ServiceStatus::Success, $saved_workout);
  }

  public function delete_public_workout($user_id, $public_workout_id)
  {
    PublicWorkout::where('user_id', $user_id)
      ->where('public_workout_id', $public_workout_id)
      ->delete();

    return new ServiceResult(ServiceStatus::Success, '');
  }
}
