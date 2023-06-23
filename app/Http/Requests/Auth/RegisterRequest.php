<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
    return [
      'name' => ['required', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'min:6', 'confirmed']
    ];
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

      'password.required' => 'The password field is requiured',
      'password.min' => 'The password must be at least 6 characters',
      'password.confirmed' => 'The password confirmation does not match'
    ];
  }
}