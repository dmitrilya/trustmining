<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ad_id'
    ];

    public function messages()
    {
        return $this->hasMany(\App\Models\Chat\Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User\User::class);
    }

    public function ad()
    {
        return $this->belongsTo(\App\Models\Ad\Ad::class);
    }
}
