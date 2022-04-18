<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Length extends Model
{
  use HasFactory, SoftDeletes;

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
  public function descriptions()
  {
    return $this->hasMany(LengthDescription::class);
  }
}
