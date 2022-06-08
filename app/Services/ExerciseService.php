<?php

namespace App\Services;

use App\Models\Exercise;
use App\Validators\ExerciseValidator;
use Illuminate\Http\Request;

class ExerciseService
{
  protected $validator;

  public function __construct(ExerciseValidator $validator)
  {
    $this->validator = $validator;
  }

  private function find_exercise($user_id, $exercise_id)
  {
    $exercise = Exercise::where('user_id', $user_id)
      ->where('id', $exercise_id)
      ->first();

    return $exercise;
  }

  public function create_exercise(Request $request): ServiceResult
  {
    $title = $request->input('title');
    $type = $request->input('type');

    $exercise = Exercise::create([
      'title' => $title,
      'type' => $type,
    ]);

    return new ServiceResult(ServiceStatus::Success, $exercise);
  }

  public function update_exercise(Request $request, $user_id, $exercise_id): ServiceResult
  {
    $exercise = $this->find_exercise($user_id, $exercise_id);

    $title = $request->input('title') ?? $exercise->title;
    $type = $request->input('type') ?? $exercise->type;

    $exercise->update([
      'title' => $title,
      'type' => $type,
    ]);

    return new ServiceResult(ServiceStatus::Success, $exercise);
  }

  public function delete_exercise($user_id, $exercise_id)
  {
    $exercise = $this->find_exercise($user_id, $exercise_id);
    $exercise->delete();
  }
}
