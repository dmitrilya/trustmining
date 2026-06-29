<?php

namespace App\Http\Controllers\Insight;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\Insight\StoreChannelRequest;
use App\Http\Requests\Insight\UpdateChannelRequest;

use App\Services\Insight\ChannelService;

use App\Models\Insight\Channel;

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
     * @param  \App\Http\Requests\Insight\StoreChannelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChannelRequest $request)
    {
        $channel = $this->service->store($request->user(), $request->name, $request->slug, $request->brief_description, $request->description, $request->file('logo'), $request->file('banner'));

        Redirect::to('/')
            ->withErrors(['success' => __('Channel created successfully')])
            ->sendHeaders();

        return response()->json([
            'success' => true,
            'redirect' => route('insight.channel.show', ['channel' => $channel->slug])
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Insight\Channel  $channel
     * @return \Illuminate\View\View
     */
    public function show(Channel $channel): View
    {
        return view('insight.channel.show', [
            'channel' => $channel,
            'series' => $channel->series->map(function ($series) {
                $series->contents = $series->getContent();
                $series->contents_count = $series->contents->count();
                return $series;
            }),
            'newArticles' => $channel->moderatedArticles()->orderByDesc('created_at')->paginate(4),
            'popularArticles' => $channel->moderatedArticles()->orderByDesc('views_count')->paginate(4),
            'newPosts' => $channel->moderatedPosts()->orderByDesc('created_at')->paginate(4),
            'popularPosts' => $channel->moderatedPosts()->orderByDesc('views_count')->paginate(4),
            'newVideos' => $channel->moderatedVideos()->orderByDesc('created_at')->paginate(4),
            'popularVideos' => $channel->moderatedVideos()->orderByDesc('views_count')->paginate(4)
        ]);
    }

    /**
     * Display a channel statistics.
     *
     * @param \App\Models\Insight\Channel  $channel
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

        Redirect::to('/')
            ->withErrors(['success' => __('Channel updated successfully')])
            ->sendHeaders();

        return response()->json([
            'success' => true,
            'redirect' => route('insight.channel.show', ['channel' => $channel->slug])
        ]);
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

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Insight\Channel  $channel
     * @param  string  $type
     * @param  string  $order
     * @return \Illuminate\Http\Response
     */
    public function getContent(Channel $channel, string $type, string $order)
    {
        $modelClass = Relation::getMorphedModel($type);

        if (!$modelClass) abort(404, "Morph type [{$type}] not found.");

        $content = $modelClass::where('moderation', false)->where('channel_id', $channel->id)
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
