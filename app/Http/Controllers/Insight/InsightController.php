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
        return view('insight.index', [
            'topChannels' => Channel::orderByDesc('active_subscribers_count')->limit(10)->get(),
            'newArticles' => Article::where('moderation', false)->orderByDesc('created_at')->paginate(4),
            'popularArticles' => Article::where('moderation', false)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newPosts' => Post::where('moderation', false)->orderByDesc('created_at')->paginate(4),
            'popularPosts' => Post::where('moderation', false)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newVideos' => Video::where('moderation', false)->orderByDesc('created_at')->paginate(4),
            'popularVideos' => Video::where('moderation', false)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
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

        return view('insight.index', [
            'topChannels' => Channel::orderByDesc('active_subscribers_count')->limit(10)->get(),
            'newArticles' => Article::where('moderation', false)->whereIn('channel_id', $channelIds)->orderByDesc('created_at')->paginate(4),
            'popularArticles' => Article::where('moderation', false)->whereIn('channel_id', $channelIds)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newPosts' => Post::where('moderation', false)->whereIn('channel_id', $channelIds)->orderByDesc('created_at')->paginate(4),
            'popularPosts' => Post::where('moderation', false)->whereIn('channel_id', $channelIds)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
                ->orderByDesc('recent_views_count')->paginate(4),
            'newVideos' => Video::where('moderation', false)->whereIn('channel_id', $channelIds)->orderByDesc('created_at')->paginate(4),
            'popularVideos' => Video::where('moderation', false)->whereIn('channel_id', $channelIds)
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
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

        $content = $modelClass::where('moderation', false);

        if ($order == 'new') $content = $content->orderByDesc('created_at');
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

        $content = $modelClass::where('moderation', false)->whereIn('channel_id', $channelIds);

        if ($order == 'new') $content = $content->orderByDesc('created_at');
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
