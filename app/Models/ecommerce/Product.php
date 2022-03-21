<?php

namespace App\Models\ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'products';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'product_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'model',
    'sku',
    'upc',
    'ean',
    'jan',
    'isbn',
    'mpn',
    'location',
    'quantity',
    'stock_status_id',
    'image',
    'manufacturer_id',
    'shipping',
    'price',
    'points',
    'tax_class_id',
    'date_available',
    'weight',
    'weight_class_id',
    'length',
    'width',
    'height',
    'length_class_id',
    'subtract',
    'minimum',
    'sort_order',
    'status',
  ];

  /**
   * Get the SEO for the product.
   */
  public function seo()
  {
    return $this->hasMany(Seo::class, 'foreign_id', 'product_id')
      ->whereHas('seo', function ($query) {
        $query->where('type', 'PRODUCT');
      });
  }
}
