<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRMSystem extends Model
{
    use HasFactory;

    protected $table = 'crm_systems';

    public $timestamps = false;

    public function crmConnections()
    {
        return $this->hasMany(CRMConnection::class);
    }
}
