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
        ]);

        $video->preview = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id);
        $video->save();

        if ($data['series_id']) $video->series()->attach($data['series_id']);

        $video->moderations()->create(['data' => $video->attributesToArray()]);

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
        if ($data['preview']) $changings['preview'] = $this->saveFile($data['preview'], 'insight/' . $channel->slug, 'video_preview', $video->id);

        if ($data['series_id']) $video->series()->sync([$data['series_id']]);

        if (!empty($changings)) $video->moderations()->create(['data' => $changings]);

        return $video;
    }

    public function filter($request = null)
    {
        $videos = Video::where('moderation', false)->with(['channel' => fn($q) => $q->select(['id', 'name', 'slug', 'logo'])->withCount('activeSubscribers')])
            ->select(['id', 'title', 'preview', 'channel_id', 'url', 'created_at', 'updated_at'])->withCount(['likes', 'views']);

        if (isset($request)) {
        } else $videos = $videos->orderBy('created_at', 'desc');

        return $videos;
    }
}
