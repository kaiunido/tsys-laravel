<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  /**
   * Tabela associada a model.
   *
   * @var string
   */
  protected $table = 'products';

  /**
   * Atributos que são atribuíveis em massa.
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
   * Faz os relacionamento de um para um com a descrição do produto.
   */
  public function description()
  {
    return $this->hasOne(ProductDescription::class);
  }
}
