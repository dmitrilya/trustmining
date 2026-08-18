<?php

namespace App\Http\Controllers\Insight;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\View\View;

use App\Models\Insight\Channel;
use App\Models\Insight\Content\Article;
use App\Models\Insight\Content\Post;
use App\Models\Insight\Content\Video;

class InsightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $now = now();
        $threeMonthsAgo = now()->subMonths(3);

        return view('insight.index', [
            'topChannels' => Channel::orderByDesc('active_subscribers_count')->limit(10)->get(),
            'newArticles' => Article::published($now)->orderByDesc('published_at')->paginate(4),
            'popularArticles' => Article::published($now)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', $threeMonthsAgo)])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newPosts' => Post::published($now)->orderByDesc('published_at')->paginate(4),
            'popularPosts' => Post::published($now)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', $threeMonthsAgo)])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newVideos' => Video::published($now)->orderByDesc('published_at')->paginate(4),
            'popularVideos' => Video::published($now)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', $threeMonthsAgo)])
                ->orderByDesc('recent_views_count')->paginate(4)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function subscriptions(): View
    {
        /** @var \App\Models\User\User $user */
        $user = auth()->user();
        $channelIds = $user->activeSubscriptions()->pluck('id');

        $now = now();
        $threeMonthsAgo = now()->subMonths(3);

        return view('insight.index', [
            'topChannels' => Channel::orderByDesc('active_subscribers_count')->limit(10)->get(),
            'newArticles' => Article::publishedInChannels($channelIds, $now)->orderByDesc('published_at')->paginate(4),
            'popularArticles' => Article::publishedInChannels($channelIds, $now)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', $threeMonthsAgo)])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newPosts' => Post::publishedInChannels($channelIds, $now)->orderByDesc('published_at')->paginate(4),
            'popularPosts' => Post::publishedInChannels($channelIds, $now)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', $threeMonthsAgo)])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newVideos' => Video::publishedInChannels($channelIds, $now)->orderByDesc('published_at')->paginate(4),
            'popularVideos' => Video::publishedInChannels($channelIds, $now)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', $threeMonthsAgo)])
                ->orderByDesc('recent_views_count')->paginate(4)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $type
     * @param  string  $order
     * @return \Illuminate\Http\Response
     */
    public function getContent(string $type, string $order)
    {
        $modelClass = Relation::getMorphedModel($type);

        if (!$modelClass) abort(404, "Morph type [{$type}] not found.");

        $content = $modelClass::published();

        if ($order == 'new') $content = $content->orderByDesc('published_at');
        else $content = $content->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
            ->orderByDesc('recent_views_count');

        $content = $content->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $content,
                'blade' => "insight.$type.components.card",
                'model' => $type
            ])->render(),
            'hasMore' => $content->hasMorePages()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $type
     * @param  string  $order
     * @return \Illuminate\Http\Response
     */
    public function getSubscriptionsContent(string $type, string $order)
    {
        /** @var \App\Models\User\User $user */
        $user = auth()->user();
        $channelIds = $user->activeSubscriptions()->pluck('id');

        $modelClass = Relation::getMorphedModel($type);

        if (!$modelClass) abort(404, "Morph type [{$type}] not found.");

        $content = $modelClass::publishedInChannels($channelIds);

        if ($order == 'new') $content = $content->orderByDesc('published_at');
        else $content = $content->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
            ->orderByDesc('recent_views_count');

        $content = $content->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $content,
                'blade' => "insight.$type.components.card",
                'model' => $type
            ])->render(),
            'hasMore' => $content->hasMorePages()
        ]);
    }
}
