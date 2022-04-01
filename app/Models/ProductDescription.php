<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
  use HasFactory;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'product_id',
    'language_id',
    'name',
    'description',
  ];

  /**
   * Pega o produto que possui a descrição.
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  /**
   * Relacionamentos com idiomas
   */
  public function language()
  {
    return $this->belongsTo(Language::class);
  }
}
