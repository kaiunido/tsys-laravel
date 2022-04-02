<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
  use HasFactory, SoftDeletes;

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
