<?php

namespace App\Http\Controllers\Insight\Content;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Insight\Content\StorePostRequest;
use App\Http\Requests\Insight\Content\UpdatePostRequest;
use App\Http\Requests\Insight\StoreCommentRequest;
use App\Http\Requests\Insight\UpdateCommentRequest;


use App\Services\Insight\Content\PostService;
use App\Http\Traits\ViewTrait;

use App\Models\Insight\Content\Post;
use App\Models\Insight\Channel;

class PostController extends Controller
{
    use ViewTrait;

    protected $service;

    public function __construct(PostService $service)
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
        $posts = $this->service->filter($request)->paginate(12);

        if ($request->ajax()) return response()->json([
            'html' => view('insight.post.components.list', compact('posts'))->render(),
            'hasMore' => $posts->hasMorePages()
        ]);

        return view('insight.post.index', [
            'posts' => $posts,
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
        return view('insight.post.create', ['channel' => $channel]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Insight\StorePostRequest  $request
     * @param  \App\Models\Insight\Channel
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Channel $channel)
    {
        $this->service->store($channel, [
            'preview' => $request->preview,
            'content' => $request->content,
            'series_id' => $request->series_id
        ]);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('The post has been sent for moderation')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Post $post)
    {
        $user = Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $channel->user_id) && $post->moderation)
            return back()->withErrors(['forbidden' => __('Unavailable post')]);

        $this->addView(request(), $post);

        return view('insight.post.show', [
            'channel' => $channel,
            'post' => $post,
            'comments' => $post->comments()->with([
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
     * @param  \App\Http\Requests\Insight\UpdatePostRequest  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Channel $channel, Post $post)
    {
        if ($post->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $this->service->update($channel, $post, [
            'preview' => $request->preview,
            'content' => $request->content,
            'series_id' => $request->series_id
        ]);

        return redirect()->route('insight.post.show', ['channel' => $channel->slug, 'post' => $post->id])
            ->withErrors(['success' => __('The post has been sent for moderation')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Channel $channel, Post $post)
    {
        if ($request->user()->id != $channel->user_id) return back()->withErrors(['success' => __('No access rights')]);

        $this->service->destroy($post);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('The post has been removed')]);
    }

    /**
     * Comment post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function comment(StoreCommentRequest $request, Channel $channel, Post $post)
    {
        $comment = $this->service->comment($post, $request->text, $request->user()->id, $request->parent_id);
        $comments = $post->comments()->where('id', '>', $request->last_id)->with([
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
                'comments' => $comments,
                'channel' => $channel,
                'modelType' => 'post',
                'model' => $post
            ])->render(),
            'html_reply' => $request->parent_id ? view('insight.components.comments.reply', [
                'reply' => $comment,
                'channel' => $channel,
                'modelType' => 'post',
                'model' => $post
            ])->render() : null,
            'last_id' => $comments->first()?->id
        ]);
    }
}
