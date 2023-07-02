<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Test\StoreRequest;
use App\Http\Requests\Dashboard\Test\UpdateRequest;
use App\Http\Resources\Test\TestResource;
use App\Models\Test;
use Excepton;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Helper\Utils;

class TestController extends Controller
{
  protected $table = 'tests';
  public function __construct()
  {
    $this->middleware('auth:sanctum');
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return JsonResponse
   * @throws Exception
   */
  public function index(Request $request): JsonResponse
  {
    return response()->json(['items' => TestResource::collection(Test::all())]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param StoreRequest $request
   * @return JsonResponse
   */
  public function store(StoreRequest $request): JsonResponse
  {
    $request->validated();
    $test = new Test();
    $test->name = $request->get('name');
    $test->email = $request->get('email');
    $test->description = $request->get('description');
    $test->status = $request->get('status');
    $test->price = $request->get('price');

    $test = Utils::filterData($this->table, $test, [0,1]);

    if ($test->save()) {
      return response()->json(['message' => 'Data saved correctly', 'test' => new TestResource($test)]);
    }
    return response()->json(['messages' => 'An error occured while saving data'], 500);
  }

  /**
   * Display the specified resource.
   *
   * @param Test $test
   * @return JsonResponse
   */
  public function show(Test $test): JsonResponse
  {
    return response()->json(new TestResource($test));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param Test $test
   * @return JsonResponse
   */
  public function update(UpdateRequest $request, Test $test): JsonResponse
  {
    $request->validated();
    $test->name = $request->get('name');
    $test->email = $request->get('email');
    $test->description = $request->get('description');
    $test->status = $request->get('status');
    $test->price = $request->get('price');

    $test = Utils::filterData($this->table, $test, [0,1]);

    if ($test->save()) {
      return response()->json(['message' => 'Data updated correctly', 'test' => new TestResource($test)]);
    }
    return response()->json(['message' => 'An error occurred while saving data'], 500);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Test $test
   * @return JsonResponse
   * @throws Exception
   */
  public function destroy(Test $test): JsonResponse
  {
    if (!Utils::checkPermissionToDelete($this->table)) {
      return response()->json(['message' => 'You don\'t have permission to delete.'], 403);
    }
    if ($test->delete()) {
      return response()->json(['message' => 'Data deleted successfully']);
    }
    return response()->json(['message' => 'An error occurred while deleting data'], 500);
  }
}