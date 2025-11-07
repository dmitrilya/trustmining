<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRMConnection extends Model
{
    use HasFactory;

    protected $table = 'crm_connections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'crm_system_id',
        'external_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crmSystem()
    {
        return $this->belongsTo(CRMSystem::class);
    }
}
