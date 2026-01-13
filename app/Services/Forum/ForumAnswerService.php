<?php

namespace App\Services\Forum;

use App\Services\YandexGPTService;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ModerationTrait;
use App\Models\User\User;

class ForumAnswerService
{
    use FileTrait, ModerationTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, string $text, array|null $images, int $forumQuestionId)
    {
        $answer = $user->forumAnswers()->create([
            'text' => $text,
            'images' => [],
            'forum_question_id' => $forumQuestionId
        ]);

        $answer->images = $this->saveFiles($images, 'forum', 'answer', $answer->id);
        $answer->save();

        $moderation = $answer->moderations()->create(['data' => $answer->attributesToArray()]);
        $moderation->moderation_status_id = 1;
        $this->acceptModeration(true, $moderation);

        //(new YandexGPTService())->moderateText($answer->text, $answer);

        return $answer;
    }
}
