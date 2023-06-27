<?php

namespace App\Http\Resources\UserRole;

use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param Request $request
   * @return array
   * @throws Exception
   */
  public function toArray($request)
  {
    /** @var UserRole $userRole */
    $userRole = $this;
    return [
      'id' => $userRole->id,
      'name' => $userRole->name,
      'users' => $userRole->users()->count(),
      'permissions' => $userRole->getPermissions(),
    ];
  }
}