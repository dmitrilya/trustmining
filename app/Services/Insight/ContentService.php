<?php

namespace App\Services\Insight;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Traits\ModerationTrait;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ViewTrait;

use App\Models\Insight\Channel;
use App\Models\Insight\Series;
use App\Models\Insight\Comment;
use App\Models\Insight\ContentModel;
use App\Models\Morph\Moderation;
use App\Models\User\User;

abstract class ContentService
{
    use ViewTrait, FileTrait, ModerationTrait;

    /**
     * Store a newly created resource in storage.
     * 
     * @param Channel  $channel
     * @param array  $data
     * @return ?ContentModel
     */
    abstract public function store(Channel $channel, array $data): ?ContentModel;

    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param ContentModel  $model
     * @param array  $data
     * @return ?ContentModel
     */
    abstract public function update(Channel $channel, ContentModel $model, array $data): ?ContentModel;

    /**
     * Destroy the specified resource in storage.
     * 
     * @param ContentModel  $model
     * @return void
     */
    public function destroy(ContentModel $model): void
    {
        $files = [$model->preview];

        foreach ($model->moderations()->where('moderation_status_id', 1)->get() as $moderation)
            if (array_key_exists('preview', $moderation->data)) array_push($files, $moderation->data['preview']);

        Storage::disk('public')->delete($files);

        $model->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);
        $model->delete();
    }

    /**
     * Получить популярный контент за период
     */
    public function getPopular(string $modelType, int $limit = 5, string $period = 'week'): Collection
    {
        $modelClass = Relation::getMorphedModel($modelType);

        $data = Cache::remember(
            "popular_{$modelType}_{$period}_{$limit}",
            now()->addHours(6),
            function () use ($modelType, $modelClass, $period, $limit) {
                return $modelClass::query()
                    ->withCount('views')
                    ->withCount(['views as views_count_period' => fn($q) => $q->where('created_at', '>=', now()->parse("-{$period}"))])
                    ->orderByDesc('views_count_period')
                    ->limit($limit)
                    ->get()
                    ->toArray();
            }
        );

        return $modelClass::hydrate($data)->map(function ($content) {
            $content->setRelation('channel', Channel::hydrate([$content->channel])->first());
            $content->offsetUnset('channel');
            $content->setRelation('series', Series::hydrate($content->series));
            $content->offsetUnset('series');
            return $content;
        });
    }

    /**
     * Comment content
     * 
     * @param ContentModel  $model
     * @param string  $text
     * @param int  $userId
     * @param ?int  $parentId
     * @return Comment
     */
    public function comment(ContentModel $model, string $text, int $userId, ?int $parentId): Comment
    {
        return $model->comments()->create([
            'user_id' => $userId,
            'text' => $text,
            'parent_id' => $parentId
        ]);
    }

    /**
     * Moderate content
     * 
     * @param Channel  $channel
     * @param ContentModel  $model
     * @param array  $data
     * @return Moderation
     */
    public function moderate(Channel $channel, ContentModel $model, array $data): Moderation
    {
        $moderation = $model->moderations()->create(['data' => $data]);

        $hasCompany = $channel->user->company && !$channel->user->company->moderation;

        $hasRecentModeratedContent = $model->newQuery()
            ->where('channel_id', $channel->id)
            ->where('moderation', false)
            ->where('created_at', '>=', now()->subMonths(3))
            ->exists();

        if ($hasCompany || $hasRecentModeratedContent) {
            $moderation->moderation_status_id = 1;
            $this->acceptModeration(true, $moderation, User::whereHas('role', fn($q) => $q->where('name', 'admin'))->value('id'));
        }

        return $moderation;
    }
}
