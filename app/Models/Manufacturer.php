<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * Atributos atribuíveis em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'sort_order',
    ];

    /**
     * Relacionamento com produtos
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
