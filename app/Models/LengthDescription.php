<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LengthDescription extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * Atributos atribuíveis em massa.
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
     * Relacionamento com length.
     *
     * @return BelongsTo
     */
    public function length(): BelongsTo
    {
        return $this->belongsTo(Length::class);
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
