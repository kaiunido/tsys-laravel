<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Length extends Model
{
  use HasFactory;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'value'
  ];

  /**
   * Relacionamento com a descrição da unidade de medida
   */
  public function description()
  {
    $this->hasMany(LengthDescription::class);
  }
}
