<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Insight\Channel;
use App\Models\Insight\Content\Article;
use App\Models\Insight\Content\Post;
use App\Models\Insight\Content\Video;
use App\Models\Insight\Series;
use App\Models\User\User;
use App\Models\Ad\AdCategory;
use App\Models\Ad\Ad;
use Illuminate\Support\Facades\DB;

class SearchService
{
    public function search(string $query): array
    {
        $query = trim($query);

        if ($query === '') {
            return [];
        }

        $searchMap = [
            'ads'       => [__('Advertisements'), 'searchAds'],
            'models'    => [__('Models'), 'searchModels'],
            'companies' => [__('Companies'), 'searchUsers'],
            'articles'  => [__('Articles'), 'searchArticles'],
            'channels'  => [__('Channels'), 'searchChannels'],
            'brands'    => [__('Brands'), 'searchBrands'],
            'posts'     => [__('Posts'), 'searchPosts'],
            'videos'    => [__('Videos'), 'searchVideos'],
            'series'    => [__('Series'), 'searchSeries'],
        ];

        return collect($searchMap)
            ->map(fn($config) => [
                'label' => $config[0],
                'items' => $this->{$config[1]}($query),
            ])
            ->filter(fn($category) => $category['items']->isNotEmpty())
            ->all();
    }

    private function searchBrands(string $query): Collection
    {
        return AsicBrand::search($query, 10)->map(fn(AsicBrand $brand) => [
            'name' => $brand->name,
            'caption' => 'TM Wiki',
            'icon' => null,
            'href' => route('database.asic-miners.brand', [
                'asicBrand' => $brand->slug,
            ]),
        ])->values();
    }

    private function searchModels(string $query): Collection
    {
        return AsicModel::search($query, 20, null, '-3 months')->loadMissing([
            'asicBrand',
            'algorithm',
        ])->map(fn(AsicModel $model) => [
            'name' => $model->name,
            'caption' => $model->asicBrand->name . ' · ' . $model->algorithm->name,
            'icon' => null,
            'href' => route('database.asic-miners.model', [
                'asicBrand' => $model->asicBrand->slug,
                'asicModel' => $model->slug,
            ]),
        ])->values();
    }

    private function searchArticles(string $query): Collection
    {
        return Article::search($query, 10, null, '-2 weeks')->loadMissing(['channel', 'series'])->map(fn(Article $article) => [
            'name' => $article->title,
            'caption' => $article->channel->name . (($series = $article->series->first()) ? ' · ' . $series->name : '') . ' · ' . $article->subtitle,
            'icon' => null,
            'href' => route('insight.article.show', [
                'channel' => $article->channel->slug,
                'article' => $article->id . '-' . Str::slug($article->title),
            ]),
        ])->values();
    }

    private function searchPosts(string $query): Collection
    {
        return Post::search($query, 10, null, '-2 weeks')->loadMissing(['channel', 'series'])->map(fn(Post $post) => [
            'name' => str($post->content)->stripTags()->limit(70),
            'caption' => $post->channel->name . (($series = $post->series->first()) ? ' · ' . $series->name : ''),
            'icon' => null,
            'href' => route('insight.post.show', [
                'channel' => $post->channel->slug,
                'post' => $post->id,
            ]),
        ])->values();
    }

    private function searchVideos(string $query): Collection
    {
        return Video::search($query, 10, null, '-2 weeks')->loadMissing(['channel', 'series'])->map(fn(Video $video) => [
            'name' => $video->title,
            'caption' => $video->channel->name . (($series = $video->series->first()) ? ' · ' . $series->name : ''),
            'icon' => null,
            'href' => route('insight.video.show', [
                'channel' => $video->channel->slug,
                'video' => $video->id . '-' . Str::slug($video->title),
            ]),
        ])->values();
    }

    private function searchSeries(string $query): Collection
    {
        return Series::search($query, 10)->loadMissing(['channel'])->map(fn(Series $series) => [
            'name' => $series->name,
            'caption' => $series->channel->name . ' · ' . $series->description,
            'icon' => null,
            'href' => route('insight.channel.series.show', [
                'channel' => $series->channel->slug,
                'series' => $series->id . '-' . Str::slug($series->name),
            ]),
        ])->values();
    }

    private function searchChannels(string $query): Collection
    {
        return Channel::search($query, 10)->map(fn(Channel $channel) => [
            'name' => $channel->name,
            'caption' => $channel->brief_description,
            'icon' => null,
            'href' => route('insight.channel.show', [
                'channel' => $channel->slug,
            ]),
        ])->values();
    }

    private function searchUsers(string $query): Collection
    {
        return User::search($query, 10, fn($builder) => $builder->isSeller())->loadMissing(['company'])->map(fn(User $user) => [
            'name' => $user->name,
            'caption' => __($user->company?->card['type'] ?? 'Private person'),
            'icon' => null,
            'href' => route('company', [
                'user' => $user->slug,
            ]),
        ])->values();
    }

    private function searchAds(string $query): Collection
    {
        $minersCategoryId = AdCategory::where('name', 'miners')->value('id');

        if (!$minersCategoryId) return collect();

        $ads = Ad::search(
            $query,
            PHP_INT_MAX,
            fn($builder) => $builder->where('ad_category_id', $minersCategoryId)->active()
        );

        if ($ads->isEmpty()) return collect();

        $modelIds = $ads
            ->pluck('asicVersion.asic_model_id')
            ->filter()
            ->unique()
            ->values();

        $modelViews = DB::table('views')
            ->select('viewable_id')
            ->selectRaw('COUNT(*) AS views_count')
            ->where('viewable_type', (new AsicModel())->getMorphClass())
            ->whereIn('viewable_id', $modelIds)
            ->where('created_at', '>=', now()->subMonths(3))
            ->groupBy('viewable_id')
            ->pluck('views_count', 'viewable_id');

        return $ads->sort(function (Ad $a, Ad $b) use ($modelViews) {
            $relevance = ($b->relevance ?? 0) <=> ($a->relevance ?? 0);

            if ($relevance !== 0) return $relevance;

            $aModelId = $a->asicVersion->asic_model_id;
            $bModelId = $b->asicVersion->asic_model_id;

            $views = ($modelViews[$bModelId] ?? 0) <=> ($modelViews[$aModelId] ?? 0);

            if ($views !== 0) return $views;

            $aFree = (float) $a->price === 0.0;
            $bFree = (float) $b->price === 0.0;

            if ($aFree !== $bFree) return $aFree <=> $bFree;

            $aPrice = (float) $a->price;
            $bPrice = (float) $b->price;

            if (!(bool) $a->with_vat) $aPrice *= 1.20;

            if (!(bool) $b->with_vat) $bPrice *= 1.20;

            $aRate = (float) ($a->coin->rate ?? 0);
            $bRate = (float) ($b->coin->rate ?? 0);

            return ($aPrice * $aRate) <=> ($bPrice * $bRate);
        })->take(20)->values()->loadMissing(['user', 'office.cityRelation', 'asicVersion.asicModel.asicBrand', 'coin'])->map(fn(Ad $ad) => [
            'name' => $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement . ' ' . $ad->price . $ad->coin->abbreviation,
            'caption' => $ad->asicVersion->asicModel->asicBrand->name . ' · ' . $ad->user->name . ' · ' . $ad->office->city,
            'icon' => null,
            'href' => route('ads.asic.show', [
                'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
                'asicModel' => $ad->asicVersion->asicModel->slug,
                'asicVersion' => $ad->asicVersion->hashrate . $ad->asicVersion->measurement,
                'ad' => $ad->user->slug . '-' . $ad->id,
            ]),
        ])->values();
    }
}
