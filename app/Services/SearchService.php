<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
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

class SearchService
{
    public function search(string $query): array
    {
        if ($query === '') return [];

        $searchMap = [
            'ads'    => [__('Advertisements'), 'searchAds'],
            'models'    => [__('Models'), 'searchModels'],
            'companies'     => [__('Companies'), 'searchUsers'],
            'articles'  => [__('Articles'), 'searchArticles'],
            'channels'  => [__('Channels'), 'searchChannels'],
            'brands'    => [__('Brands'), 'searchBrands'],
            'posts'     => [__('Posts'), 'searchPosts'],
            'videos'    => [__('Videos'), 'searchVideos'],
            'series'    => [__('Series'), 'searchSeries'],
        ];

        return collect($searchMap)
            ->map(fn($config, $key) => [
                'label' => $config[0],
                'items' => $this->{$config[1]}($query),
            ])
            ->filter(fn($category) => $category['items']->isNotEmpty())
            ->all();
    }

    private function searchBrands(string $query): Collection
    {
        return AsicBrand::query()
            ->withRelevance($query)
            ->take(10)->get()->map(fn(AsicBrand $brand) => [
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
        return AsicModel::query()->withRelevance($query)->withViewsPriority('-3 months')
            ->take(20)->get()->map(fn(AsicModel $model) => [
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
        return Article::query()->withRelevance($query)->withViewsPriority('-2 weeks')
            ->take(10)->get()->map(fn(Article $article) => [
                'name' => $article->title,
                'caption' => $article->channel->name . ' · ' . $article->subtitle,
                'icon' => null,
                'href' => route('insight.article.show', [
                    'channel' => $article->channel->slug,
                    'article' => $article->id . '-' . Str::slug($article->title)
                ]),
            ])->values();
    }

    private function searchPosts(string $query): Collection
    {
        return Post::query()->withRelevance($query)->withViewsPriority('-2 weeks')
            ->take(10)->get()->map(fn(Post $post) => [
                'name' => str($post->content)->stripTags()->limit(70),
                'caption' => $post->channel->name,
                'icon' => null,
                'href' => route('insight.post.show', [
                    'channel' => $post->channel->slug,
                    'post' => $post->id
                ]),
            ])->values();
    }

    private function searchVideos(string $query): Collection
    {
        return Video::query()->withRelevance($query)->withViewsPriority('-2 weeks')
            ->take(10)->get()->map(fn(Video $video) => [
                'name' => $video->title,
                'caption' => $video->channel->name,
                'icon' => null,
                'href' => route('insight.video.show', [
                    'channel' => $video->channel->slug,
                    'video' => $video->id . '-' . Str::slug($video->title)
                ]),
            ])->values();
    }

    private function searchSeries(string $query): Collection
    {
        return Series::query()->withRelevance($query)
            ->take(10)->get()->map(fn(Series $series) => [
                'name' => $series->name,
                'caption' => $series->channel->name . ' · ' . $series->description,
                'icon' => null,
                'href' => route('insight.channel.series.show', [
                    'channel' => $series->channel->slug,
                    'series' => $series->id . '-' . Str::slug($series->name)
                ]),
            ])->values();
    }

    private function searchChannels(string $query): Collection
    {
        return Channel::query()->withRelevance($query)
            ->take(10)->get()->map(fn(Channel $channel) => [
                'name' => $channel->name,
                'caption' => 'TM Insight',
                'icon' => null,
                'href' => route('insight.channel.show', [
                    'channel' => $channel->slug,
                ]),
            ])->values();
    }

    private function searchUsers(string $query): Collection
    {
        return User::isSeller()->withRelevance($query)
            ->take(10)->get()->map(fn(User $user) => [
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
        return Ad::query()->where('ad_category_id', AdCategory::where('name', 'miners')->value('id'))
            ->withRelevance($query)
            ->withAsicModelViewsPriority()
            ->leftJoin('coin_rates', fn($join) => $join->on('coin_rates.coin_id', '=', 'ads.coin_id')
                ->whereRaw(
                    'coin_rates.created_at = (
                    SELECT MAX(inner_cr.created_at)
                    FROM coin_rates inner_cr
                    WHERE inner_cr.coin_id = ads.coin_id)'
                ))
            ->with(['office.cityRelation'])
            ->orderByRaw('ads.price = 0 ASC')
            ->orderByRaw('(CASE WHEN ads.with_vat = 0 THEN ads.price * 1.20 ELSE ads.price END) * coin_rates.rate ASC')
            ->take(20)->get()->map(fn(Ad $ad) => [
                'name' => $ad->asicVersion->asicModel->asicBrand->name . ' ' . $ad->asicVersion->asicModel->name,
                'caption' => $ad->user->name . ' · ' . $ad->office->city,
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
