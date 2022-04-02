<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeightDescription extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'weight_id',
    'language_id',
    'name',
    'unit',
  ];

  /**
   * Relacionamento com length
   */
  public function weight()
  {
    return $this->belongsTo(Weight::class);
  }

  /**
   * Relacionamento com idioma
   */
  public function language()
  {
    return $this->belongsTo(Language::class);
  }
}
