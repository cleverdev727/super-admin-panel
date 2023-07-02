<?php

namespace App\Http\Requests\Dashboard\Test;

use Illuminate\Foundation\Http\FormRequest;
use App\Helper\Utils;

class UpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $table = 'tests';

    $ary = [
      'name' => ['required', 'max:255'],
      'email' => ['required', 'email', 'max:255'],
      'description' => ['required', 'max:255'],
      'status' => ['required'],
      'price' => ['required', 'max:255'],
    ];

    $ary = Utils::filterRule($table, $ary);

    return $ary;
  }

  /**
   * Get custom messages for validator errors.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'name.required' => 'The name field is required',
      'name.max' => 'The name may not be greater than 255 characters',

      'email.required' => 'The email field is required',
      'email.email' => 'The email must be a valid email address',
      'email.max' => 'The email may not be greater than 255 characters',

      'description.required' => 'The description field is required',
      'description.max' => 'The description may not be greater than 255 characters',

      'status.required' => 'The status field is required',

      'price.required' => 'The price field is required',
      'price.max' => 'The price may not be greater than 255 characters',
    ];
  }
}