<?php

namespace App\Services\Insight\Content;

use \App\Services\Insight\ContentService;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\UploadedFile;

use App\Models\Insight\Content\Article;
use App\Models\Insight\Channel;
use App\Models\Insight\ContentModel;

class ArticleService extends ContentService
{
    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param array{title: string, subtitle: string, preview: UploadedFile, content: string, tags: array, series_id: ?int} $data
     * @return ?Article
     */
    public function store(Channel $channel, array $data): ?ContentModel
    {
        $content = Purifier::clean(htmlspecialchars_decode($data['content']), 'insight_article');

        if ($content === "") return null;

        $article = $channel->articles()->create([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'],
            'preview' => '',
            'content' => $content,
            'tags' => $data['tags'],
        ]);

        $time = time();
        $article->preview = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [928, 696], 90);
        $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [340, 255]);
        $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [284, 213]);
        $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [192, 144]);
        $article->save();

        if ($data['series_id']) $article->series()->attach($data['series_id']);

        $moderation = $article->moderations()->create(['data' => $article->attributesToArray()]);
        if (!$channel->user->company?->moderation) {
            $moderation->moderation_status_id = 1;
            $this->acceptModeration(true, $moderation);
        }

        return $article;
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param Article  $article
     * @param array{title: string, subtitle: string, preview: ?UploadedFile, content: string, tags: array, series_id: ?int} $data
     * @return ?Article
     */
    public function update(Channel $channel, ContentModel $article, array $data): ?ContentModel
    {
        $content = Purifier::clean(htmlspecialchars_decode($data['content']), 'insight_article');

        if ($content === "") return null;

        $changings = [];

        if ($data['title'] != $article->title) $changings['title'] = $data['title'];
        if ($data['subtitle'] != $article->subtitle) $changings['subtitle'] = $data['subtitle'];
        if ($content != $article->content) $changings['content'] = $content;
        if ($data['preview']) {
            $time = time();
            $changings['preview'] = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [928, 696], 90);
            $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [340, 255]);
            $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [284, 213]);
            $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'article_preview', $article->id, $time, [192, 144]);
        }
        if (count(array_diff($article->tags, $data['tags'])) || count(array_diff($data['tags'], $article->tags))) $changings['tags'] = $data['tags'];

        if ($data['series_id']) $article->series()->sync([$data['series_id']]);

        if (!empty($changings)) {
            $moderation = $article->moderations()->create(['data' => $changings]);
            if (!$channel->user->company?->moderation) {
                $moderation->moderation_status_id = 1;
                $this->acceptModeration(true, $moderation);
            }
        }

        return $article;
    }

    public function filter($request = null)
    {
        $articles = Article::where('moderation', false)->with(['channel' => fn($q) => $q->select(['id', 'name', 'slug', 'logo'])->withCount('activeSubscribers'), 'series:id,name'])
            ->select(['id', 'title', 'subtitle', 'preview', 'channel_id', 'created_at', 'updated_at'])->withCount(['likes', 'views']);

        if (isset($request)) {
            if ($request->tags && count($request->tags)) $articles = $articles->where(function ($q) use ($request) {
                $q->whereJsonContains('tags', $request->tags[0]);

                for ($i = 1; $i < count($request->tags); $i++) {
                    $q->orWhereJsonContains('tags', $request->tags[$i]);
                }
            });

            if ($request->sort) {
                switch ($request->sort) {
                    case 'newest':
                        $articles = $articles->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $articles = $articles->orderBy('created_at');
                        break;
                    case 'more_likes':
                        $articles = $articles->orderBy('likes_count', 'desc');
                        break;
                    case 'less_likes':
                        $articles = $articles->orderBy('likes_count');
                        break;
                    case 'more_views':
                        $articles = $articles->orderBy('views_count', 'desc');
                        break;
                    case 'less_views':
                        $articles = $articles->orderBy('views_count');
                        break;
                }
            } else $articles = $articles->orderBy('created_at', 'desc');
        } else $articles = $articles->orderBy('created_at', 'desc');

        return $articles;
    }
}
