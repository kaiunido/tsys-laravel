<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seo extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * Atributos que são atribuíveis em massa.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'searchable_type',
    'searchable_id',
    'language_id',
    'meta_title',
    'meta_description',
    'meta_tags',
    'query',
    'meta_url',
  ];

  /**
   * Pega a model do relacionamento searchable
   */
  public function searchable()
  {
    return $this->morthTo();
  }
}
