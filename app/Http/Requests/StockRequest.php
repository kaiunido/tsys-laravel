<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
    $prefix = 'stock.*.';

    return [
      $prefix . 'nf_id' => 'nullable|string',
      $prefix . 'product_id' => 'nullable|integer',
      $prefix . 'quantity' => 'required|integer',
      $prefix . 'quantity_sold' => 'nullable|integer',
      $prefix . 'has_stock' => 'nullable|boolean',
      $prefix . 'price' => 'required|numeric',
    ];
  }
}
