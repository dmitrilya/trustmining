<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\Metrics\NetworkTrait;
use Carbon\Carbon;

class Coin extends Model
{
    use HasFactory, NetworkTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profit',
        'difficulty',
        'fee',
        'reward_block',
    ];

    protected $with = ['latestRate'];

    protected function rate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->latestRate?->rate ?? 0,
        );
    }

    public function algorithm()
    {
        return $this->belongsTo(\App\Models\Database\Algorithm::class);
    }

    public function coinRates()
    {
        return $this->hasMany(\App\Models\Metrics\CoinRate::class);
    }

    public function latestRate()
    {
        return $this->hasOne(\App\Models\Metrics\CoinRate::class)->latestOfMany();
    }

    public function networkHashrates()
    {
        return $this->hasMany(\App\Models\Metrics\NetworkHashrate::class);
    }

    public function latestNetworkHashrate()
    {
        return $this->hasOne(\App\Models\Metrics\NetworkHashrate::class)->latestOfMany();
    }

    public function networkDifficulties()
    {
        return $this->hasMany(\App\Models\Metrics\NetworkDifficulty::class);
    }

    public function latestNetworkDifficulty()
    {
        return $this->hasOne(\App\Models\Metrics\NetworkDifficulty::class)->latestOfMany();
    }

    public function difficultyData(): ?array
    {
        $difficulties = $this->networkDifficulties()->where('created_at', '>', Carbon::now()->subDays(31))
            ->latest()->select(['difficulty', 'need_blocks', 'created_at'])->get();

        if (!$difficulties->count()) return null;

        $lastDifficulty = $difficulties->first();
        $prediction = null;
        $needBlocksTime = null;

        if ($this->target) {
            $recalculateDates = [];

            foreach ($difficulties as $i => $difficulty) {
                if (!isset($difficulties[$i + 1])) return null;

                if ($difficulty->need_blocks > $difficulties[$i + 1]->need_blocks) {
                    if (!$needBlocksTime) {
                        if ($i == 0) $needBlocksTime = __('Time calculation');
                        else {
                            $blockTime = ($lastDifficulty->created_at - $difficulty->created_at) / ($difficulty->need_blocks - $lastDifficulty->need_blocks);
                            $needBlocksTime = $this->needBlocksTime($lastDifficulty, $blockTime);
                            $prediction = round((($this->target / $blockTime) - 1) * 100, 2);
                        }
                    }

                    array_push($recalculateDates, $difficulty->created_at);
                    if (count($recalculateDates) == 2) break;
                }
            }
        }

        return [
            'lastDifficulty' => $lastDifficulty,
            'needBlocksTime' => $needBlocksTime,
            'prediction' => $prediction
        ];
    }
}
