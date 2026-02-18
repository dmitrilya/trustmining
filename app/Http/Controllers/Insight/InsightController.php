<?php

namespace App\Http\Controllers\Insight;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
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
        $data = Cache::remember('insight_home_data', 3600, fn() => [
            'topChannels' => Channel::orderByDesc('active_subscribers_count')->limit(10)->get(),
            'newArticles' => Article::where('moderation', false)
                ->with(['channel' => fn($q) => $q->select(['id', 'name', 'logo', 'slug'])->withCount('activeSubscribers')])->latest()->limit(50)->get(),
            'popularArticles' => Article::where('moderation', false)
                ->with(['channel' => fn($q) => $q->select(['id', 'name', 'logo', 'slug'])->withCount('activeSubscribers')])
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
                ->orderByDesc('recent_views_count')->limit(50)->get(),
            'newPosts' => Post::where('moderation', false)
                ->with(['channel' => fn($q) => $q->select(['id', 'name', 'logo', 'slug'])->withCount('activeSubscribers')])->latest()->limit(50)->get(),
            'popularPosts' => Post::where('moderation', false)
                ->with(['channel' => fn($q) => $q->select(['id', 'name', 'logo', 'slug'])->withCount('activeSubscribers')])
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
                ->orderByDesc('recent_views_count')->limit(50)->get(),
            'newVideos' => Video::where('moderation', false)
                ->with(['channel' => fn($q) => $q->select(['id', 'name', 'logo', 'slug'])->withCount('activeSubscribers')])->latest()->limit(50)->get(),
            'popularVideos' => Video::where('moderation', false)
                ->with(['channel' => fn($q) => $q->select(['id', 'name', 'logo', 'slug'])->withCount('activeSubscribers')])
                ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
                ->orderByDesc('recent_views_count')->limit(50)->get()
        ]);

        return view('insight.index', $data);
    }
}
