<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeightDescription extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * Atributos atribuíveis em massa.
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
     * Relacionamento com length.
     *
     * @return BelongsTo
     */
    public function weight(): BelongsTo
    {
        return $this->belongsTo(Weight::class);
    }

    /**
     * Relacionamento com idioma.
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
