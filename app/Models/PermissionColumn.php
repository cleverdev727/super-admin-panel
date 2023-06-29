<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionColumn
 *
 * @property int $id
 * @property string $column
 * @property Carboon|null $created_at
 * @property Carboon|null $updated_at
 */

class PermissionColumn extends Model
{
  use HasFactory;

}