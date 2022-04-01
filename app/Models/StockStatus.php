<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockStatus extends Model
{
  use HasFactory;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'language_id',
    'name',
  ];

  /**
   * Relacionamento com produto
   */
  public function product()
  {
    $this->hasMany(Product::class);
  }
}
