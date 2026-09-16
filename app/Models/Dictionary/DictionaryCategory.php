<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionaryCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function dictionaryTerms()
    {
        return $this->hasMany(\App\Models\Dictionary\DictionaryTerm::class);
    }
}
