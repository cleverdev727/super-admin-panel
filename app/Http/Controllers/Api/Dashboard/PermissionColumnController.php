<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PermissionColumn;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PermissionColumnController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:sanctum');
  }

  /**
   * Display a listing of Resource.
   *
   * @param Request $request
   * @return JsonResponse
   * @throws Exception
   */
  public function index(Request $request): JsonResponse
  {
    return response()->json(PermissionColumn::pluck('column'));
  }

  /**
   * Save checked columns.
   *
   * @param Request $request
   * @return JsonResponse
   * @throws Exception
   */
  public function save(Request $request): JsonResponse
  {
    $columns = $request->post('columns');
    $rows = PermissionColumn::all();
    foreach($rows as $row) {
      $oldcolumn = $row->column;
      $key = array_search($oldcolumn, $columns);
      if (is_numeric($key)) {
        array_splice($columns, $key, 1);
      } else {
        $permissionColumn = PermissionColumn::where('column', $oldcolumn);
        $permissionColumn->delete();
      }
    }
    foreach ($columns as $column) {
      $permissionColumn = new PermissionColumn();
      $permissionColumn->column = $column;
      $permissionColumn->save();
    }
    return response()->json(['message' => 'Data saved correctly']);
  }

  /**
   * Get the Table & Columns from database
   * @param Request $request
   * @return JsonResponse
   * @throws Exception
   */
  public function getTables(Request $request): JsonResponse
  {
    $tables = Schema::getAllTables();
    $tableColumns = [];
    $exceptTableArray = ['failed_jobs', 'migrations', 'password_reset_tokens', 'permission_columns', 'personal_access_tokens', 'user_roles'];
    foreach ($tables as $table) {
      $tableName = $table->Tables_in_super_admin;
      if (!in_array($tableName, $exceptTableArray)) {
        $columns = Schema::getColumnListing($tableName);
        $tableColumns[$tableName] = $columns;
      }
    }
    return response()->json($tableColumns);
  }
}