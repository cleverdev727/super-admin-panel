<?php

namespace App\Helper;

use App\Http\Resources\UserRole\UserRoleResource;
use Auth;

class Utils
{
  static function getColumnPermissions() {
    $curUser = Auth::user();
    $userRole = new UserRoleResource($curUser->userRole);
    $columnPermissions = $userRole->getColumnPermissions();
    return $columnPermissions == null ? [] : $columnPermissions;
  }

  static function filterData($table, $data, $vals = [0]) {
    $columnPermissions = self::getColumnPermissions();

    foreach ($columnPermissions as $key => $value) {
      if (in_array($value, $vals)) {
        list($tbl, $col) = explode('-', $key);
        if($tbl == $table) {
          unset($data[$col]);
        }
      }
    }

    return $data;
  }

  static function filterRule($table, $data) {
    $columnPermissions = self::getColumnPermissions();

    foreach ($columnPermissions as $key => $value) {
      if ($value != 2) {
        list($tbl, $col) = explode('-', $key);
        if($tbl == $table) {
          $index = array_search('required', $data[$col]);
          if(is_numeric($index)) {
            unset($data[$col][$index]);
          }
          foreach ($data[$col] as $ind => $str) {
            if (strpos($str, 'exists:') !== false) {
              unset($data[$col][$ind]);
            }
          }
        }
      }
    }

    return $data;
  }

  static function checkPermissionToDelete($table) {
    $columnPermissions = self::getColumnPermissions();

    foreach ($columnPermissions as $key => $value) {
      if ($value != 2) {
        list($tbl, $col) = explode('-', $key);
        if($tbl == $table) {
          return false;
        }
      }
    }
    return true;
  }
}