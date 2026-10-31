<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Enums\RatingSource;

class ExternalSourcesMapping extends Model
{
    protected $table = 'external_sources_mapping';

    protected $fillable = [
        'ratable_type',
        'ratable_id',
        'rating_source_id',
        'external_id',
    ];

    /**
     * Автоматическое приведение строки из базы к вашему Enum
     */
    protected $casts = [
        'rating_source_id' => RatingSource::class,
    ];

    /**
     * Полиморфная связь с целевой моделью (Office или User)
     */
    public function ratable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Связь со ВСЕЙ историей изменений рейтингов для этого источника
     */
    public function history(): HasMany
    {
        return $this->hasMany(ExternalRating::class, 'mapping_id');
    }

    /**
     * Связь только с ПОСЛЕДНЕЙ (актуальной) записью рейтинга
     */
    public function latestRating(): HasOne
    {
        return $this->hasOne(ExternalRating::class, 'mapping_id')->latestOfMany();
    }
}
