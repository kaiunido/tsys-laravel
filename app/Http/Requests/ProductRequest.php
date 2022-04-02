<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    $prefix = 'product.';
    return [
      $prefix . 'model' => 'required|string',
      $prefix . 'sku' => 'nullable|string',
      $prefix . 'isbn13' => 'nullable|string|size:13|unique:App\Models\Product,isbn13',
      $prefix . 'condition' => 'required|boolean',
      $prefix . 'location' => 'nullable|string',
      $prefix . 'stock_status_id' => 'required|integer',
      $prefix . 'image' => 'nullable|string|url',
      $prefix . 'manufacturer_id' => 'required|integer',
      $prefix . 'shipping' => 'required|boolean',
      $prefix . 'points' => 'nullable|integer',
      $prefix . 'date_available' => 'required|date',
      $prefix . 'weight' => 'nullable|numeric',
      $prefix . 'weight_id' => 'required|integer',
      $prefix . 'length' => 'nullable|numeric',
      $prefix . 'width' => 'nullable|numeric',
      $prefix . 'height' => 'nullable|numeric',
      $prefix . 'length_id' => 'required|integer',
      $prefix . 'subtract' => 'required|boolean',
      $prefix . 'minimum' => 'required|integer',
      $prefix . 'sort_order' => 'required|integer',
      $prefix . 'status' => 'required|boolean',
      $prefix . 'viewed' => 'nullable|integer',
    ];
  }
}
