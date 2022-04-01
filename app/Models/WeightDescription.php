<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightDescription extends Model
{
  use HasFactory;

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
    $this->belongsTo(Weight::class);
  }

  /**
   * Relacionamento com idioma
   */
  public function language()
  {
    $this->belongsTo(Language::class);
  }
}
