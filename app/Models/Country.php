<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends BaseModel
{
  use HasFactory, SoftDeletes;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'alfa2',
    'alfa3',
  ];
}
