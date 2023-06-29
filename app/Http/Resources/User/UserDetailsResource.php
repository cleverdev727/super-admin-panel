<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserRole\UserRoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Helper\Utils;

class UserDetailsResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    $table = 'users';

    /** @var User $user */
    $user = $this;
    $ary = [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'role_id' => $user->role_id,
      'status' => (bool) $user->status,
      'created_at' => (bool) $user->created_at->toISOString(),
      'updated_at' => (bool) $user->updated_at->toISOString(),
    ];

    $ary = Utils::filterData($table, $ary);

    return $ary;
  }
}