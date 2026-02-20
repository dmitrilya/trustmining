<?php

namespace App\Http\Controllers\Insight\Content;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Insight\Content\StoreArticleRequest;
use App\Http\Requests\Insight\Content\UpdateArticleRequest;
use App\Http\Requests\Insight\StoreCommentRequest;
use App\Http\Requests\Insight\UpdateCommentRequest;

use App\Services\Insight\Content\ArticleService;
use App\Http\Traits\ViewTrait;

use App\Models\Insight\Content\Article;
use App\Models\Insight\Channel;

class ArticleController extends Controller
{
    use ViewTrait;

    protected $service;

    public function __construct(ArticleService $service)
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
        $articles = $this->service->filter($request)->paginate(12);

        if ($request->ajax()) return response()->json([
            'html' => view('insight.article.components.list', compact('articles'))->render(),
            'hasMore' => $articles->hasMorePages()
        ]);

        return view('insight.article.index', [
            'articles' => $articles,
            'tags' => Article::pluck('tags')->flatten()->groupBy(fn($tag) => $tag)->sortByDesc(fn($tagGroup) => $tagGroup->count())->keys()
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
        return view('insight.article.create', [
            'channel' => $channel,
            'tags' => Article::pluck('tags')->flatten()->groupBy(fn($tag) => $tag)->sortByDesc(fn($tagGroup) => $tagGroup->count())->keys()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Insight\StoreArticleRequest  $request
     * @param  \App\Models\Insight\Channel
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request, Channel $channel)
    {
        $this->service->store($channel, [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'preview' => $request->preview,
            'content' => $request->content,
            'tags' => $request->tags ?? [],
            'series_id' => $request->series_id
        ]);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('The article has been sent for moderation')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Article $article)
    {
        $user = Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $channel->user_id) && $article->moderation)
            return back()->withErrors(['forbidden' => __('Unavailable article')]);

        $this->addView(request(), $article);

        return view('insight.article.show', [
            'channel' => $channel,
            'article' => $article,
            'comments' => $article->comments()->with([
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
     * @param  \App\Http\Requests\Insight\UpdateArticleRequest  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Channel $channel, Article $article)
    {
        if ($article->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $this->service->update($channel, $article, [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'preview' => $request->preview,
            'content' => $request->content,
            'tags' => $request->tags ?? [],
            'series_id' => $request->series_id
        ]);

        return redirect()->route('insight.article.show', ['channel' => $channel->slug, 'article' => $article->id . '-' . mb_strtolower(str_replace(' ', '-', $article->title))]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Channel $channel, Article $article)
    {
        if ($request->user()->id != $channel->user_id) return back()->withErrors(['success' => __('No access rights')]);

        $this->service->destroy($article);

        return redirect()->route('insight.channel.show', ['channel' => $channel->slug])->withErrors(['success' => __('The article has been removed')]);
    }

    /**
     * Comment post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insight\Channel  $channel
     * @param  \App\Models\Insight\Content\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function comment(StoreCommentRequest $request, Channel $channel, Article $article)
    {
        $comment = $this->service->comment($article, $request->text, $request->user()->id, $request->parent_id);
        $comments = $article->comments()->where('id', '>', $request->last_id)->with([
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
                'modelType' => 'article',
                'model' => $article
            ])->render(),
            'html_reply' => $request->parent_id ? view('insight.components.comments.reply', [
                'reply' => $comment,
                'channel' => $channel,
                'modelType' => 'article',
                'model' => $article
            ])->render() : null,
            'last_id' => $comments->first()?->id
        ]);
    }
}
