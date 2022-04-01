<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
  use HasFactory;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'code',
    'locale',
    'image',
  ];

  /**
   * Relacionamento com descrição dos produtos.
   */
  public function productDescription()
  {
    return $this->hasMany(Product::class);
  }
}
