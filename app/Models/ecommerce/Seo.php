<?php

namespace App\Models\ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
  use HasFactory;
  
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'seo';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'seo_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'type',
    'foreign_id',
    'language_id',
    'meta_title',
    'meta_description',
    'meta_tags',
    'query',
    'meta_url'
  ];

  /**
   * Get the product that owns the SEO.
   */
  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id', 'foreign_id')
      ->where('type', 'PRODUCT');
  }
}
