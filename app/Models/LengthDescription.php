<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LengthDescription extends Model
{
  use HasFactory;

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
    $this->belongsTo(Length::class);
  }

  /**
   * Relacionamento com idioma
   */
  public function language()
  {
    $this->belongsTo(Language::class);
  }
}
