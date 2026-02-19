<?php

namespace App\Services\Insight\Content;

use \App\Services\Insight\ContentService;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\UploadedFile;

use App\Models\Insight\Content\Post;
use App\Models\Insight\Channel;
use App\Models\Insight\ContentModel;

class PostService extends ContentService
{
    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param array{preview: UploadedFile, content: string, series_id: ?int} $data
     * @return ?Post
     */
    public function store(Channel $channel, array $data): ?ContentModel
    {
        $content = Purifier::clean(htmlspecialchars_decode($data['content']), 'insight_post');

        if ($content === "") return null;

        $post = $channel->posts()->create([
            'preview' => '',
            'content' => $content,
        ]);

        $post->preview = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'post_preview', $post->id);
        $post->save();

        if ($data['series_id']) $post->series()->attach($data['series_id']);

        $post->moderations()->create(['data' => $post->attributesToArray()]);

        return $post;
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param Post  $post
     * @param array{preview: ?UploadedFile, content: string, series_id: ?int} $data
     * @return ?Post
     */
    public function update(Channel $channel, ContentModel $post, array $data): ?ContentModel
    {
        $content = Purifier::clean(htmlspecialchars_decode($data['content']), 'insight_post');

        if ($content === "") return null;

        $changings = [];

        if ($content != $post->content) $changings['content'] = $content;
        if ($data['preview']) $changings['preview'] = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'post_preview', $post->id);

        if ($data['series_id']) $post->series()->sync([$data['series_id']]);

        if (!empty($changings)) $post->moderations()->create(['data' => $changings]);

        return $post;
    }

    public function filter($request = null)
    {
        $posts = Post::where('moderation', false)->with(['channel' => fn($q) => $q->select(['id', 'name', 'slug', 'logo'])])
            ->select(['id', 'preview', 'channel_id', 'content', 'created_at'])->withCount(['likes', 'views']);

        if (isset($request)) {
        } else $posts = $posts->orderBy('created_at', 'desc');

        return $posts;
    }
}
