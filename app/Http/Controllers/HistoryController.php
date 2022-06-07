<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailedHistoryResource;
use App\Http\Resources\HistoryResource;
use App\Models\History;
use App\Models\User;
use App\Services\HistoryService;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
  protected $service;

  public function __construct(HistoryService $service)
  {
    $this->service = $service;
  }

  public function index(User $user)
  {
    $histories = $user
      ->histories()
      ->get();

    if ($histories->isEmpty()) {
      return response('Histories are empty', 200);
    }

    return response(HistoryResource::collection($histories));
  }

  public function store(Request $request, $user_id)
  {
    $history = $this->service->create_history($request, $user_id);

    return response($history);
  }

  public function show(User $user, History $history)
  {
    $history_resource = new DetailedHistoryResource($history);
    return response($history_resource);
  }

  public function update(Request $request, History $history)
  {
    //
  }

  public function destroy(History $history)
  {
    //
  }
}
