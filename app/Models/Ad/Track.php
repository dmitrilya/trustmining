<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ad_id',
    ];

    public function notifications()
    {
        return $this->morphMany(\App\Models\User\Notification::class, 'notificationable');
    }
}
