<?php

namespace App\Http\Controllers\Insight;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Http\Requests\Insight\StoreSeriesRequest;
use App\Http\Requests\Insight\UpdateSeriesRequest;

use App\Services\Insight\SeriesService;

use App\Models\Insight\Channel;
use App\Models\Insight\Series;
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
            'articles' => $series->moderatedArticles,
            'posts' => $series->moderatedPosts,
            'videos' => $series->moderatedVideos
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
        $series = $this->service->update($series, $request->name);

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
}
