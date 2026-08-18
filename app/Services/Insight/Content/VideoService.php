<?php

namespace App\Services\Insight\Content;

use \App\Services\Insight\ContentService;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\UploadedFile;

use App\Models\Insight\Content\Video;
use App\Models\Insight\Channel;
use App\Models\Insight\ContentModel;

class VideoService extends ContentService
{
    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param array{preview: UploadedFile, title: string, url: string, series_id: ?int} $data
     * @return ?Video
     */
    public function store(Channel $channel, array $data): ?ContentModel
    {
        $video = $channel->videos()->create([
            'preview' => '',
            'title' => $data['title'],
            'url' => processVideoLink($data['url']),
            'published_at' => $data['published_at'],
        ]);

        $time = time();
        $video->preview = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id, $time, [340, 255], $channel->name, 85);
        $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id, $time, [284, 213], $channel->name, 85);
        $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id, $time, [192, 144], $channel->name, 85);

        if ($data['series_id']) $video->series()->attach($data['series_id']);

        $this->moderate($channel, $video, $video->attributesToArray());

        return $video;
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param Video  $video
     * @param array{preview: ?UploadedFile, title: string, series_id: ?int} $data
     * @return ?Video
     */
    public function update(Channel $channel, ContentModel $video, array $data): ?ContentModel
    {
        $changings = [];

        if ($data['title'] != $video->title) $changings['title'] = $data['title'];
        if ($data['preview']) {
            $time = time();
            $changings['preview'] = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id, $time, [340, 255], $channel->name, 85);
            $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id, $time, [284, 213], $channel->name, 85);
            $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id, $time, [192, 144], $channel->name, 85);
        }

        if ($data['series_id']) $video->series()->sync([$data['series_id']]);

        if ($data['published_at'] !== $video->published_at->format('Y-m-d H:i:s') && ($video->published_at->isFuture() || $video->created_at->diffInHours(now()) < 1))
            $changings['published_at'] = $data['published_at'];

        if (!empty($changings)) $this->moderate($channel, $video, $changings);

        return $video;
    }

    public function filter($request = null)
    {
        $videos = Video::published()
            ->with(['channel' => fn($q) => $q->select(['id', 'name', 'slug', 'logo'])->withCount('activeSubscribers'), 'series:id,name'])
            ->select(['id', 'title', 'preview', 'channel_id', 'url', 'published_at', 'updated_at'])->withCount(['likes', 'views']);

        if (isset($request)) {
            if ($request->sort) {
            } else $videos = $videos->orderBy('published_at', 'desc');
        } else $videos = $videos->orderBy('published_at', 'desc');

        return $videos;
    }
}
