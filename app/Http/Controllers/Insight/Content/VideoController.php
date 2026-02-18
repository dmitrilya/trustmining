<?php

namespace App\Http\Controllers\Insight\Content;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\Insight\Content\StoreVideoRequest;
use App\Http\Requests\Insight\Content\UpdateVideoRequest;
use App\Http\Requests\Insight\StoreCommentRequest;
use App\Http\Requests\Insight\UpdateCommentRequest;


use App\Services\Insight\Content\VideoService;
use App\Http\Traits\ViewTrait;

use App\Models\Insight\Content\Video;
use App\Models\Insight\Channel;

class VideoController extends Controller
{
    use ViewTrait;

    protected $service;

    public function __construct(VideoService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('insight.video.index', [
            'videos' => $this->service->filter($request)->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Insight\Channel
     * @return \Illuminate\Http\Response
     */
    public function create(Channel $channel)
    {
        return view('insight.video.create', ['channel' => $channel]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Insight\StoreVideoRequest  $request
     * @param  \App\Models\Insight\Channel
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoRequest $request, Channel $channel)
    {
        $this->service->store($channel, [
            'preview' => $request->preview,
            'title' => $request->title,
            'url' => $request->url,
            'series_id' => $request->series_id
        ]);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('The video has been sent for moderation')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Video $video)
    {
        $user = Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $channel->user_id) && $video->moderation)
            return back()->withErrors(['forbidden' => __('Unavailable video')]);

        $this->addView(request(), $video);

        return view('insight.video.show', [
            'channel' => $channel,
            'video' => $video,
            'comments' => $video->comments()->with([
                'user:id,name',
                'user.company:user_id,logo',
                'user.channel:user_id,name,logo',
                'reactions',
                'replies',
                'replies.user:id,name',
                'replies.user.company:user_id,logo',
                'replies.user.channel:user_id,name,logo',
                'replies.reactions'
            ])->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Insight\UpdateVideoRequest  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVideoRequest $request, Channel $channel, Video $video)
    {
        if ($video->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $this->service->update($channel, $video, [
            'preview' => $request->preview,
            'title' => $request->title,
            'series_id' => $request->series_id
        ]);

        return redirect()->route('insight.video.show', ['channel' => $channel->slug, 'video' => $video->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Channel $channel, Video $video)
    {
        if ($request->user()->id != $channel->user_id) return back()->withErrors(['success' => __('No access rights')]);

        $this->service->destroy($video);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('The video has been removed')]);
    }

    /**
     * Comment video
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function comment(StoreCommentRequest $request, Channel $channel, Video $video)
    {
        $comment = $this->service->comment($video, $request->text, $request->user()->id, $request->parent_id);
        $comments = $video->comments()->where('id', '>', $request->last_id)->with([
            'user:id,name',
            'user.company:user_id,logo',
            'user.channel:user_id,name,logo',
            'reactions',
            'replies',
            'replies.user:id,name',
            'replies.user.company:user_id,logo',
            'replies.user.channel:user_id,name,logo',
            'replies.reactions'
        ])->get()->sortByDesc('id');

        return response()->json([
            'success' => true,
            'html_comments' => view('insight.components.comments.comment-list', [
                'comments' => $comments, 'channel' => $channel, 'modelType' => 'video', 'model' => $video
            ])->render(),
            'html_reply' => $request->parent_id ? view('insight.components.comments.reply', [
                'reply' => $comment, 'channel' => $channel, 'modelType' => 'video', 'model' => $video
            ])->render() : null,
            'last_id' => $comments->first()?->id
        ]);
    }
}
