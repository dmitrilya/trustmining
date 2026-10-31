<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalRating extends Model
{
    protected $fillable = [
        'mapping_id',
        'rating',
        'reviews_count',
    ];

    protected $casts = [
        'rating' => 'float',
        'reviews_count' => 'integer',
    ];

    /**
     * Обратная связь к маппингу, чтобы знать, к какому источнику/офису принадлежит запись
     */
    public function mapping(): BelongsTo
    {
        return $this->belongsTo(ExternalSourcesMapping::class, 'mapping_id');
    }
}
