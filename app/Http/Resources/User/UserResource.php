<?php

namespace App\Http\Resources\User;

use App\Http\Resources\UserRole\UserRoleResource;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  /**
   * Transform the resource collection into an array.
   *
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    $table = 'users';
    $columnPermissions = [];
    $curUser = Auth::user();
    $userRole = new UserRoleResource($curUser->userRole);
    $columnPermissions = $userRole->getColumnPermissions();

    /** @var User $user */
    $user = $this;

    $ary = [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'status' => $user->status,
      'role' => new UserRoleResource($user->userRole),
      'role_id' => $user->role_id,
      'created_at' => $user->created_at->toISOString(),
      'updated_at' => $user->updated_at->toISOString()
    ];

    foreach ($columnPermissions as $key => $value) {
      if ($value == 0) {
        list($tbl, $col) = explode('-', $key);
        if($tbl == $table) {
          unset($ary[$col]);
        }
      }
    }

    if (isset($columnPermissions[$table . '-role_id'])) {
      unset($ary['role']);
    }

    return $ary;
  }
}