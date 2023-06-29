<?php

namespace App\Http\Requests\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Helper\Utils;

class StoreRequest extends FormRequest
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
    $table = 'users';

    $ary = [
      'name' => ['required', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users'],
      'status' => ['required'],
      'role_id' => ['required', 'exist:user_roles,id'],
      'password' => ['required', 'min:6']
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
      'email.unique' => 'The email has already been taken',

      'status.required' => 'The status field is required',

      'role_id.required' => 'The role field is required',
      'role_id.exists' => 'The selected role is invalid',

      'password.required' => 'The password field is required',
      'password.min' => 'The password must be at least 255 characters',
    ];
  }
}