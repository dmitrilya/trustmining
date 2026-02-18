<?php

namespace App\Services\Insight;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Traits\FileTrait;
use App\Http\Traits\ViewTrait;

use App\Models\Insight\Channel;
use App\Models\Insight\Comment;
use App\Models\Insight\ContentModel;

abstract class ContentService
{
    use ViewTrait, FileTrait;

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
    public function getPopular(string $modelClass, int $limit = 5, string $period = 'week'): Collection
    {
        $startDate = now()->parse("-{$period}");

        return $modelClass::query()->withCount(['views as views_count_period' => fn($q) => $q->where('created_at', '>=', $startDate)])
            ->withCount('views')->orderByDesc('views_count_period')->limit($limit)->get();
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
}
