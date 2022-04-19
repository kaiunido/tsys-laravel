<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weight extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * Atributos atribuíveis em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value'
    ];

    /**
     * Relacionamento com a descrição da unidade de peso.
     *
     * @return HasMany
     */
    public function descriptions(): HasMany
    {
        return $this->hasMany(WeightDescription::class);
    }

    /**
     * Override para utilizar o evento "deleting" e deletar as descrições.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($weight) {
            $weight->descriptions()->delete();
        });
    }
}
