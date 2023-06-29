<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Route;

use App\Models\PermissionColumn;

/**
 * App\Models\UserRole
 *
 * @property int $id
 * @property string $name
 * @property array|null $permissions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class UserRole extends Model
{
  use HasFactory;

  /**
   * The attributes that should be cast to native types
   *
   * @var array
   */
  protected $casts = [
    'permissions' => 'json',
  ];

  /**
   * Get the users for the user role
   *
   * @return HasMany
   */
  public function users(): HasMany
  {
    return $this->hasMany(User::class, 'role_id');
  }

  /**
   * @param $route
   * @return bool
   * @throws Exception
   */
  public function checkPermission($route): bool
  {
    if ($this->id === 1) {
      return true;
    }
    return in_array($route, json_decode((string) $this->permissions, true, 512, JSON_THROW_ON_ERROR), true);
  }

  /**
   * @return array
   * @throws Exception
   */
  public function getPermissions(): array
  {
    $controllers = [];
    $permissions = json_decode((string) $this->permissions, true, 512, JSON_THROW_ON_ERROR);
    foreach(Route::getRoutes()->getIterator() as $route) {
      if (strpos($route->uri, 'api/dashboard') !== false) {
        $path = str_replace('\\', '.', explode('@', str_replace($route->action['controller'].'\\', '', $route->action['controller']))[0]);
        $controllers[$path] = $this->id === 1 ? true : in_array($path, $permissions, true);
      }
    }
    return $controllers;
  }

  /**
   * @return array
   * @throws Exception
   */
  public function getColumnPermissions(): array
  {
    $permissionColumns = PermissionColumn::all();
    $columns = [];
    $columnPermissions = [];
    $column_permissions = json_decode((string) $this->column_permissions, true, 512, JSON_THROW_ON_ERROR);
    foreach ($column_permissions as $value) {
      list($key, $val) = explode('-', $value);
      $columnPermissions[$key] = $val;
    }
    foreach ($permissionColumns as $value) {
      $columns[$value['column']] = isset($columnPermissions[$value['id']]) ? $columnPermissions[$value['id']] : 0;
    }
    return $columns;
  }
}