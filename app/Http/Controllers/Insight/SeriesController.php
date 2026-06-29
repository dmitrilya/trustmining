<?php

namespace App\Http\Controllers\Insight;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\Insight\StoreSeriesRequest;
use App\Http\Requests\Insight\UpdateSeriesRequest;

use App\Services\Insight\SeriesService;

use App\Models\Insight\Channel;
use App\Models\Insight\Series;

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
     * @param  \App\Models\Insight\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeriesRequest $request, Channel $channel)
    {
        $this->service->store($channel, $request->name, $request->description);

        Redirect::to('/')
            ->withErrors(['success' => __('Series created successfully')])
            ->sendHeaders();

        return response()->json([
            'success' => true,
        ]);
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
        $this->service->update($series, $request->name, $request->description);

        return response()->json([
            'success' => true,
            'message' => __('Series updated successfully')
        ]);
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
     * @param  string  $type
     * @param  string  $order
     * @return \Illuminate\Http\Response
     */
    public function getContent(Channel $channel, Series $series, string $type, string $order)
    {
        $modelClass = Relation::getMorphedModel($type);

        if (!$modelClass) abort(404, "Morph type [{$type}] not found.");

        $content = $modelClass::where('moderation', false)->where('series_id', $series->id)
            ->orderByDesc($order == 'new' ? 'created_at' : 'views_count')->paginate(4);

        return response()->json([
            'html' => view('insight.components.carousel-list', [
                'items' => $content,
                'blade' => "insight.{$type}.components.card",
                'model' => $type
            ])->render(),
            'hasMore' => $content->hasMorePages()
        ]);
    }
}
