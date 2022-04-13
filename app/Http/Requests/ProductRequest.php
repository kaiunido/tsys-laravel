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
    $prefixData = $prefix . 'data.';
    $prefixDesc = $prefix . 'descriptions.*.';
    $prefixSeo = $prefix . 'seo.*.';
    $prefixStock = $prefix . 'stock.*.';

    return [
      $prefix . 'data' => 'required|array',
      $prefix . 'descriptions' => 'required|array',
      $prefix . 'seo' => 'required|array',
      $prefix . 'stock' => 'required|array',

      $prefixData . 'model' => 'required|string',
      $prefixData . 'sku' => 'nullable|string',
      $prefixData . 'isbn13' => 'nullable|string|size:13|unique:App\Models\Product,isbn13',
      $prefixData . 'condition' => 'required|boolean',
      $prefixData . 'location' => 'nullable|string',
      $prefixData . 'stock_status_id' => 'required|integer',
      $prefixData . 'image' => 'nullable|string|url',
      $prefixData . 'manufacturer_id' => 'required|integer',
      $prefixData . 'shipping' => 'required|boolean',
      $prefixData . 'points' => 'nullable|integer',
      $prefixData . 'date_available' => 'required|date',
      $prefixData . 'weight' => 'nullable|numeric',
      $prefixData . 'weight_id' => 'required|integer',
      $prefixData . 'length' => 'nullable|numeric',
      $prefixData . 'width' => 'nullable|numeric',
      $prefixData . 'height' => 'nullable|numeric',
      $prefixData . 'length_id' => 'required|integer',
      $prefixData . 'subtract' => 'required|boolean',
      $prefixData . 'minimum' => 'required|integer',
      $prefixData . 'sort_order' => 'required|integer',
      $prefixData . 'status' => 'required|boolean',
      $prefixData . 'viewed' => 'nullable|integer',

      ...(new (ProductDescriptionRequest::class))->rules($prefixDesc),
      ...(new (SeoRequest::class))->rules($prefixSeo),
      ...(new (StockRequest::class))->rules($prefixStock),
    ];
  }
}
