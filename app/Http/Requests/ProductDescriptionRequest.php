<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductDescriptionRequest extends FormRequest
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
  public function rules($prefix = '')
  {
    return [
      $prefix . 'language_id' => 'required|integer',
      $prefix . 'name' => 'required|string',
      $prefix . 'description' => 'nullable|string',
    ];
  }
}
