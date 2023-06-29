<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRole\StoreRequest;
use App\Http\Requests\Dashboard\UserRole\UpdateRequest;
use App\Http\Resources\UserRole\UserRoleEditResource;
use App\Http\Resources\UserRole\UserRoleResource;
use App\Models\User;
use App\Models\UserRole;
use App\Models\PermissionColumn;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Route;
use Str;

class UserRoleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:sanctum');
  }

  /**
   * Display a listing of the resource.
   *
   * @param Reuqest $request
   * @return JsonResponse
   * @throws Exception
   */
  public function index(Request $request): JsonResponse
  {
    return response()->json(['items' => UserRoleResource::collection(UserRole::all())]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param StoreRequest $request
   * @return JsonResponse
   * @throws Exception
   */
  public function store(StoreRequest $request): JsonResponse
  {
    $request->validated();
    $userRole = new UserRole();
    $userRole->name = $request->get('name');
    $userRole->permissions = json_encode(str_replace('\'"', '"', $request->get('permissions')), JSON_THROW_ON_ERROR);
    $userRole->column_permissions = json_encode(str_replace('\'"', '"', $request->get('column_permissions')), JSON_THROW_ON_ERROR);
    if ($userRole->save()) {
      return response()->json(['message' => 'Data saved correctly', 'userRole' => new UserRoleEditResource($userRole)]);
    }
    return response()->json(['message' => 'An error occured while saving data'], 500);
  }

  /**
   * Display the specified resource.
   *
   * @param UserRole $userRole
   * @return JsonResponse
   */
  public function show(UserRole $userRole): JsonResponse
  {
    return response()->json(new UserRoleEditResource($userRole));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param UserRole $userRole
   * @return JsonResponse
   * @throws Exception
   */
  public function update(UpdateRequest $request, UserRole $userRole): JsonResponse
  {
    $request->validated();
    $userRole->name = $request->get('name');
    $userRole->permissions = json_encode(str_replace('\'"', '"', $request->get('permissions')), JSON_THROW_ON_ERROR);
    $userRole->column_permissions = json_encode(str_replace('\'"', '"', $request->get('column_permissions')), JSON_THROW_ON_ERROR);
    if ($userRole->save()) {
      return response()->json(['message' => 'Data updated correctly', 'userRole' => new UserRoleEditResource($userRole)]);
    }
    return response()->json(['message' => 'An error occured while saving data'], 500);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UserRole $userRole
   * @return JsonResponse
   * @throws Exception
   */
  public function destroy(UserRole $userRole): JsonResponse
  {
    User::where('role_id', $userRole->id)->update(['role_id' => 0]);
    if ($userRole->delete()) {
      return response()->json(['message' => 'Data deleted successfully']);
    }
    return response()->json(['message' => 'An error occured while deleting data'], 500);
  }

  /**
   * @return JsonResponse
   * @throws Exception
   */
  public function permissions(): JsonResponse
  {
    $permissionsLabels = [];
    $permissionsKeys = [];
    foreach(Route::getRoutes()->getIterator() as $route) {
      if (strpos($route->uri, 'api/dashboard') !== false) {
        $path = explode('@', str_replace($route->action['controller'].'\\', '', $route->action['controller']))[0];
        $pathName = str_replace(['App\\Http\\Controllers\\Api\\', 'Controller', '\\'], '', $path);
        $key = str_replace('\\', '.', $path);
        $label = 'Manage'.strtolower(implode(' ', preg_split('/(?=[A-Z])/', Str::plural($pathName))));
        if(!in_array($key, $permissionsKeys, true)) {
          $permissionsKeys[] = $key;
        }
        $permissionsLabels[$key] = $label;
      }
    }
    return response()->json(['keys' => $permissionsKeys, 'labels' => $permissionsLabels]);
  }

  /**
   * @return JsonResponse
   * @throws Exception
   */
  public function permissionColumns(Request $request): JsonResponse
  {
    return response()->json(PermissionColumn::all());
  }
}