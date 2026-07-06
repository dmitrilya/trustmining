<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Database\Coin;

class Ad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ordering_id',
        'user_id',
        'ad_category_id',
        'asic_version_id',
        'gpu_model_id',
        'office_id',
        'description',
        'preview',
        'images',
        'props',
        'price',
        'moderation',
        'hidden',
        'coin_id',
        'with_vat'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'props' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function adCategory()
    {
        return $this->belongsTo(\App\Models\Ad\AdCategory::class);
    }

    public function asicVersion()
    {
        return $this->belongsTo(\App\Models\Database\AsicVersion::class);
    }

    public function gpuModel()
    {
        return $this->belongsTo(\App\Models\Database\GPUModel::class);
    }

    public function office()
    {
        return $this->belongsTo(\App\Models\User\Office::class);
    }

    public function coin()
    {
        return $this->belongsTo(\App\Models\Database\Coin::class);
    }

    public function moderations()
    {
        return $this->morphMany(\App\Models\Morph\Moderation::class, 'moderationable');
    }

    /**
     * @return float|null
     */
    public function getPreviousPrice(): ?float
    {
        $currentModerationId = $this->moderations()->latest('id')->value('id');
        $currentPrice = $this->price * $this->coin->rate;

        $pastModerations = $this->moderations()->where('id', '<', $currentModerationId)
            ->whereNotNull('data->price')->whereNotNull('data->coin_id')->latest('id')->get();

        foreach ($pastModerations as $moderation) {
            $oldModerationPrice = (float) data_get($moderation->data, 'price');
            $oldModerationCoinId = data_get($moderation->data, 'coin_id');

            $historicalRate = DB::table('coin_rates')->where('coin_id', $oldModerationCoinId)
                ->where('created_at', '<=', $moderation->created_at)->latest('created_at')->value('rate');

            $oldCoinRate = $historicalRate ?? (Coin::find($oldModerationCoinId)?->rate ?? 1.0);
            $oldPrice = $oldModerationPrice * $oldCoinRate;

            if (abs($currentPrice - $oldPrice) > 0.01) return $oldPrice;
        }

        return null;
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }

    public function phoneViews()
    {
        return $this->hasMany(\App\Models\Morph\View::class);
    }

    public function tracks()
    {
        return $this->morphMany(\App\Models\Morph\Track::class, 'trackable');
    }

    public function trackingUsers()
    {
        return \App\Models\User\User::query()->join('tracks', 'users.id', '=', 'tracks.user_id')
            ->where('tracks.trackable_type', $this->getMorphClass())->where('tracks.trackable_id', $this->id);
    }

    public function chats()
    {
        return $this->hasMany(\App\Models\Chat\Chat::class);
    }
}
