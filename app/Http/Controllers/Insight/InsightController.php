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
     * @return \Illuminate\Http\Response
     */
    public function getNewArticles()
    {
        $articles = Article::where('moderation', false)->orderByDesc('created_at')->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $articles,
                'blade' => 'insight.article.components.card',
                'model' => 'article'
            ])->render(),
            'hasMore' => $articles->hasMorePages()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPopularArticles()
    {
        $articles = Article::where('moderation', false)
            ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
            ->orderByDesc('recent_views_count')->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $articles,
                'blade' => 'insight.article.components.card',
                'model' => 'article'
            ])->render(),
            'hasMore' => $articles->hasMorePages()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewPosts()
    {
        $posts = Post::where('moderation', false)->orderByDesc('created_at')->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $posts,
                'blade' => 'insight.post.components.card',
                'model' => 'post'
            ])->render(),
            'hasMore' => $posts->hasMorePages()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPopularPosts()
    {
        $posts = Post::where('moderation', false)
            ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
            ->orderByDesc('recent_views_count')->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $posts,
                'blade' => 'insight.post.components.card',
                'model' => 'post'
            ])->render(),
            'hasMore' => $posts->hasMorePages()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewVideos()
    {
        $videos = Video::where('moderation', false)->orderByDesc('created_at')->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $videos,
                'blade' => 'insight.video.components.card',
                'model' => 'video'
            ])->render(),
            'hasMore' => $videos->hasMorePages()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPopularVideos()
    {
        $videos = Video::where('moderation', false)
            ->withCount(['views as recent_views_count' => fn($q) => $q->where('created_at', '>=', now()->subMonths(3))])
            ->orderByDesc('recent_views_count')->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $videos,
                'blade' => 'insight.video.components.card',
                'model' => 'video'
            ])->render(),
            'hasMore' => $videos->hasMorePages()
        ]);
    }
}
