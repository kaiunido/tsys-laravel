<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
      'country.name' => 'required|string|unique:countries,name',
      'country.alfa2' => 'required|string|size:2|unique:countries,alfa2',
      'country.alfa3' => 'required|string|size:3|unique:countries,alfa3'
    ];
  }
}
