<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
  use HasFactory;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'image',
    'sort_order',
  ];

  /**
   * Relacionamento com produtos
   */
  public function products()
  {
    $this->hasMany(Product::class);
  }
}
