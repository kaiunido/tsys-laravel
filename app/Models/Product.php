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
   * @var array<int, string>
   */
  protected $fillable = [
    'model',
    'sku',
    'isbn13',
    'condition',
    'location',
    'stock_status_id',
    'image',
    'manufacturer_id',
    'shipping',
    'points',
    'date_available',
    'weight',
    'weight_id',
    'length',
    'width',
    'height',
    'length_id',
    'subtract',
    'minimum',
    'sort_order',
    'status',
    'viewed',
  ];

  /**
   * Relacionamento com a descrição do produto.
   */
  public function description()
  {
    return $this->hasMany(ProductDescription::class);
  }

  /**
   * Relacionamento com fabricante
   */
  public function manufacturer()
  {
    $this->belongsTo(Manufacturer::class);
  }

  /**
   * Relacionamento com situação do stock
   */
  public function stockStatus()
  {
    $this->belongsTo(StockStatus::class);
  }
}
