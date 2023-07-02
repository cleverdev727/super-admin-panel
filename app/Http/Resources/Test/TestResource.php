<?php

namespace App\Http\Resources\Test;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Helper\Utils;

class TestResource extends JsonResource
{
  /**
   * Transform the resource collection into an array.
   *
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    $table = 'tests';
    /** @var Test $test */
    $test = $this;

    $ary = [
      'id' => $test->id,
      'name' => $test->name,
      'email' => $test->email,
      'description' => $test->description,
      'status' => $test->status,
      'price' => $test->price,
      'created_at' => $test->created_at->toISOString(),
      'updated_at' => $test->updated_at->toISOString()
    ];

    $ary = Utils::filterData($table, $ary);

    return $ary;
  }
}