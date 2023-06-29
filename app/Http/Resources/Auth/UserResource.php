<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\UserRole\UserRoleResource;
use App\Models\User;
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
    return $ary;
  }
}