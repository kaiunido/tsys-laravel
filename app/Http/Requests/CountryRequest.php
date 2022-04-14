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
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Retorna as regras de validação que se aplicam à solicitação.
   *
   * @return array
   */
  public function rules(): array
  {
    return [
      'country.name' => 'required|string|unique:countries,name',
      'country.alfa2' => 'required|string|size:2|unique:countries,alfa2',
      'country.alfa3' => 'required|string|size:3|unique:countries,alfa3'
    ];
  }
}
