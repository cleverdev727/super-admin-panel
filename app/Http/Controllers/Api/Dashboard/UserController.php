<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\StoreRequest;
use App\Http\Requests\Dashboard\User\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\UserRole\UserRoleResource;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use Excepton;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Helper\Utils;

class UserController extends Controller
{
  protected $table = 'users';
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
    return response()->json(['items' => UserResource::collection(User::all())]);
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
    $user = new User();
    $user->name = $request->get('name');
    $user->email = $request->get('email');
    $user->status = $request->get('status');
    $user->role_id = $request->get('role_id');
    $user->password = bcrypt($request->get('password'));

    $user = Utils::filterData($this->table, $user, [0,1]);

    if ($user->save()) {
      return response()->json(['message' => 'Data saved correctly', 'user' => new UserResource($user)]);
    }
    return response()->json(['messages' => 'An error occured while saving data'], 500);
  }

  /**
   * Display the specified resource.
   *
   * @param User $user
   * @return JsonResponse
   */
  public function show(User $user): JsonResponse
  {
    /** @var User $authUser */
    $authUser = Auth::user();
    if ($user->id === $authUser->id) {
      return response()->json(['message' => 'Can not edit your user from the user manager, go to your account page'], 406);
    }
    return response()->json(new UserResource($user));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param User $user
   * @return JsonResponse
   */
  public function update(UpdateRequest $request, User $user): JsonResponse
  {
    $request->validated();
    $user->name = $request->get('name');
    $user->email = $request->get('email');
    $user->status = $request->get('status');
    $user->role_id = $request->get('role_id');

    $user = Utils::filterData($this->table, $user, [0,1]);

    if ($user->save()) {
      return response()->json(['message' => 'Data updated correctly', 'user' => new UserResource($user)]);
    }
    return response()->json(['message' => 'An error occurred while saving data'], 500);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param User $user
   * @return JsonResponse
   * @throws Exception
   */
  public function destroy(User $user): JsonResponse
  {
    if (!Utils::checkPermissionToDelete($this->table)) {
      return response()->json(['message' => 'You don\'t have permission to delete.'], 403);
    }
    /** @var User $authUser */
    $authUser = Auth::user();
    if ($user->id === $authUser->id) {
      return response()->json(['message' => 'You can not delete your own user'], 406);
    }
    if ($user->delete()) {
      return response()->json(['message' => 'Data deleted successfully']);
    }
    return response()->json(['message' => 'An error occurred while deleting data'], 500);
  }

  public function userRoles(): JsonResponse
  {
    return response()->json(UserRoleResource::collection(UserRole::all()));
  }
}