<?php

namespace App\Services\Forum;

use App\Services\YandexGPTService;
use App\Http\Traits\FileTrait;
use App\Models\User\User;

class ForumCommentService
{
    use FileTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, string $text, array $images, int $forumAnswerId)
    {
        $comment = $user->forumComments()->create([
            'text' => $text,
            'images' => [],
            'forum_answer_id' => $forumAnswerId
        ]);

        $comment->images = $this->saveFiles($images, 'forum', 'comment', $comment->id);
        $comment->save();

        (new YandexGPTService())->moderateText($comment->text, $comment);

        return redirect()->route('forum');
    }
}
