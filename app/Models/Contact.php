<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
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
        'contact_type_id',
        'contact',
        'moderation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }
}
