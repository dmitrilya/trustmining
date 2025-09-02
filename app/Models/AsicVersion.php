<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsicVersion extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('hashrate', $value)->first() ?? abort(404);
    }

    public function asicModel()
    {
        return $this->belongsTo(AsicModel::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
