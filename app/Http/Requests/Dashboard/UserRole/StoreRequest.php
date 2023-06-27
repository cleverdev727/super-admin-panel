<?php

namespace App\Http\Requests\Dashboard\UserRole;

use Illuminate\Foundation\Http\FormRequest;

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
    return [
      'name' => ['required', 'max:255', 'unique:user_roles,name'],
      'permissions' => ['array']
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
      'name.required' => 'The name filed is required',
      'name.max' => 'The name may not be greater than 255 characters',
      'name.unique' => 'The name has already been taken',

      'permissions.array' => 'The permissions must be an array'
    ];
  }

  /**
   * Prepare the data for validation.
   *
   * @return void
   */
  protected function prepareForValidation()
  {
    $permissions = [];
    foreach($this->get('permissions') as $key => $value) {
      if ($value) {
        $permissions[] = $key;
      }
    }
    $this->merge([
      'permissions' => $permissions,
    ]);
  }
}