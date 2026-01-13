<?php

namespace App\Services\Forum;

use App\Services\YandexGPTService;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ModerationTrait;
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
}
