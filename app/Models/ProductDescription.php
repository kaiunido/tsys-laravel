<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
  use HasFactory;

  protected $hidden = [
    'product_id',
    'language_id'
  ];

  /**
   * Pega o produto que possui a descrição.
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
