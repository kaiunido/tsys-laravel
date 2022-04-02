<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockStatus extends Model
{
  use HasFactory, SoftDeletes;

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
    return $this->hasMany(Product::class);
  }
}
