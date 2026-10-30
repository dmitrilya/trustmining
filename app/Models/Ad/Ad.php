<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Searchable;
use App\Models\Database\Coin;

class Ad extends Model
{
    use HasFactory, Searchable;

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

    public static array $searchWeights = [
        'asicVersion.asicModel.name' => 8,
        'asicVersion.asicModel.asicBrand.name' => 5,
        'asicVersion.asicModel.algorithm.name' => 3,
        'user.name' => 2,
        'user.company.name' => 2,
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

    public function scopeActive(Builder $query)
    {
        return $query->where('moderation', false)->where('hidden', false);
    }

    public function scopeWithAsicModelViewsPriority(Builder $query): Builder
    {
        $since = now()->subMonths(3);

        $model = new \App\Models\Database\AsicModel();
        $viewModel = $model->views()->getRelated();

        $viewsTable = $viewModel->getTable();
        $modelTable = $model->getTable();

        $morphClass = $model->getMorphClass();

        $viewsSubquery = DB::table('asic_versions')
            ->join($modelTable, "{$modelTable}.id", '=', 'asic_versions.asic_model_id')
            ->leftJoin($viewsTable, function ($join) use ($viewsTable, $since, $morphClass, $modelTable) {
                $join->on("{$viewsTable}.viewable_id", '=', "{$modelTable}.id")
                    ->where("{$viewsTable}.viewable_type", '=', $morphClass)
                    ->where("{$viewsTable}.created_at", '>=', $since);
            })
            ->selectRaw("COUNT({$viewsTable}.id)")
            ->whereColumn('asic_versions.id', 'ads.asic_version_id');

        return $query
            ->addSelect(['recent_views_count' => $viewsSubquery])
            ->orderByDesc('recent_views_count');
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
