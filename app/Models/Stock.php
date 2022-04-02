<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
  use HasFactory;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'nf_id',
    'product_id',
    'quantity',
    'quantity_sold',
    'has_stock',
    'price',
  ];

  /**
   * Relacionamento com produto
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
