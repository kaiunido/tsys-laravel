<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LengthDescription extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'length_id',
    'language_id',
    'name',
    'unit',
  ];

  /**
   * Relacionamento com length
   */
  public function length()
  {
    return $this->belongsTo(Length::class);
  }

  /**
   * Relacionamento com idioma
   */
  public function language()
  {
    return $this->belongsTo(Language::class);
  }
}
