<?php

namespace App\Http\Controllers\Insight;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Http\Requests\Insight\StoreSeriesRequest;
use App\Http\Requests\Insight\UpdateSeriesRequest;

use App\Services\Insight\SeriesService;

use App\Models\Insight\Channel;
use App\Models\Insight\Series;
use App\Models\Insight\Content\Article;
use App\Models\Insight\Content\Post;
use App\Models\Insight\Content\Video;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    protected $service;

    public function __construct(SeriesService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Insight\StoreSeriesRequest  $request
     * @param  \App\Models\Insight\Channel
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeriesRequest $request, Channel $channel)
    {
        $series = $this->service->store($channel, $request->name);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('Series created successfully')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Insight\Channel  $channel
     * @param \App\Models\Insight\Series  $series
     * @return \Illuminate\View\View
     */
    public function show(Channel $channel, Series $series): View
    {
        return view('insight.series.show', [
            'channel' => $channel,
            'series' => $series,
            'newArticles' => $series->moderatedArticles()->orderByDesc('created_at')->paginate(4),
            'popularArticles' => $series->moderatedArticles()->orderByDesc('views_count')->paginate(4),
            'newPosts' => $series->moderatedPosts()->orderByDesc('created_at')->paginate(4),
            'popularPosts' => $series->moderatedPosts()->orderByDesc('views_count')->paginate(4),
            'newVideos' => $series->moderatedVideos()->orderByDesc('created_at')->paginate(4),
            'popularVideos' => $series->moderatedVideos()->orderByDesc('views_count')->paginate(4)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Insight\UpdateSeriesRequest  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeriesRequest $request, Channel $channel, Series $series)
    {
        $series = $this->service->update($series, $request->name, $request->description);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('Series updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Channel $channel, Series $series)
    {
        if ($request->user()->id != $channel->user_id) return back()->withErrors(['success' => __('No access rights')]);

        $this->service->destroy($series);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('The series has been removed')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function getNewArticles(Channel $channel, Series $series)
    {
        $articles = $series->moderatedArticles()->orderByDesc('created_at')->paginate(4);

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
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function getPopularArticles(Channel $channel, Series $series)
    {
        $articles = $series->moderatedArticles()->orderByDesc('views_count')->paginate(4);

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
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function getNewPosts(Channel $channel, Series $series)
    {
        $posts = $series->moderatedPosts()->orderByDesc('created_at')->paginate(4);

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
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function getPopularPosts(Channel $channel, Series $series)
    {
        $posts = $series->moderatedPosts()->orderByDesc('views_count')->paginate(4);

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
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function getNewVideos(Channel $channel, Series $series)
    {
        $videos = $series->moderatedVideos()->orderByDesc('created_at')->paginate(4);

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
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function getPopularVideos(Channel $channel, Series $series)
    {
        $videos = $series->moderatedVideos()->orderByDesc('views_count')->paginate(4);

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
