<?php

namespace App\Services\Forum;

use Illuminate\Support\Facades\Storage;
use App\Services\YandexGPTService;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ModerationTrait;

use App\Models\Forum\ForumComment;
use App\Models\User\User;

class ForumCommentService
{
    use FileTrait, ModerationTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, string $text, array|null $images, int $forumAnswerId)
    {
        $comment = $user->forumComments()->create([
            'text' => $text,
            'images' => [],
            'forum_answer_id' => $forumAnswerId
        ]);

        $comment->images = $this->saveFiles($images, 'forum', 'comment', $comment->id);
        $comment->save();

        $moderation = $comment->moderations()->create(['data' => $comment->attributesToArray()]);
        $moderation->moderation_status_id = 1;
        $this->acceptModeration(true, $moderation);

        //(new YandexGPTService())->moderateText($comment->text, $comment);

        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ForumComment $comment, string $text, array|null $images)
    {
        if ($comment->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $data = ['text' => $text];

        if ($images)
            $data['images'] = $this->saveFiles($images, 'forum', 'comment', $comment->id);

        $moderation = $comment->moderations()->create(['data' => $data]);
        $moderation->moderation_status_id = 1;
        $this->acceptModeration(true, $moderation);

        //(new YandexGPTService())->moderateText($comment->text, $comment);

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumComment $comment)
    {
        $images = [];
        $images = array_merge($images, $comment->images);

        foreach ($comment->moderations()->where('moderation_status_id', 1)->get() as $moderation)
            if (array_key_exists('images', $moderation->data)) $images = array_merge($images, $moderation->data['images']);

        Storage::disk('public')->delete($images);

        $comment->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);
        $comment->delete();
    }
}
