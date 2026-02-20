<?php

namespace App\Http\Controllers\Insight;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\Insight\StoreChannelRequest;
use App\Http\Requests\Insight\UpdateChannelRequest;

use App\Services\Insight\ChannelService;

use App\Models\Insight\Channel;
use App\Models\Insight\Content\Article;
use App\Models\Insight\Content\Post;

use Carbon\Carbon;

class ChannelController extends Controller
{
    protected $service;

    public function __construct(ChannelService $service)
    {
        $this->service = $service;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkSlug(Request $request)
    {
        if (Channel::where('slug', $request->slug)->whereNot('user_id', $request->user()->id)->exists())
            return response()->json(['success' => false, 'error' => __('The channel address is already taken')]);

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->channel) return redirect()->route('insight.channel.show', ['channel' => $user->channel->slug]);

        return view('insight.channel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Insight\StorePostRequest  $request
     * @param  \App\Models\Insight\Channel
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChannelRequest $request)
    {
        $channel = $this->service->store($request->user(), $request->name, $request->slug, $request->brief_description, $request->description, $request->file('logo'), $request->file('banner'));

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('Channel created successfully')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Insight\Channel
     * @return \Illuminate\View\View
     */
    public function show(Channel $channel): View
    {
        return view('insight.channel.show', [
            'channel' => $channel,
            'series' => $channel->series->map(function ($series) {
                $series->contents = $series->getContents();
                $series->contents_count = $series->contents->count();
                return $series;
            }),
            'articles' => $channel->moderatedArticles,
            'posts' => $channel->moderatedPosts,
            'videos' => $channel->moderatedVideos
        ]);
    }

    /**
     * Display a channel statistics.
     *
     * @param \App\Models\Insight\Channel
     * @return \Illuminate\View\View
     */
    public function statistics(Channel $channel): View
    {
        return view('insight.channel.statistics', ['channel' => $channel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Insight\Channel  $channel
     * @return \Illuminate\View\View
     */
    public function edit(Channel $channel): View
    {
        return view('insight.channel.edit', ['channel' => $channel]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Insight\UpdateChannelRequest  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel = $this->service->update($channel, $request->name, $request->slug, $request->brief_description, $request->description, $request->file('logo'), $request->file('banner'));

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('Channel updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Channel $channel)
    {
        if ($request->user()->id != $channel->user_id) return back()->withErrors(['forbidden' => __('No access rights')]);

        $this->service->destroy($channel);

        return redirect()->route('insight.index')->withErrors(['success' => __('The channel has been removed')]);
    }

    public function toggleSubscription(Request $request, Channel $channel)
    {
        return $this->service->toggleSubscription($request->user(), $channel);
    }
}
