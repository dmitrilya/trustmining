<?php

namespace App\Services\Forum;

use App\Services\YandexGPTService;
use App\Http\Traits\FileTrait;
use App\Models\User\User;

class ForumAnswerService
{
    use FileTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, string $text, array $images, int $forumQuestionId)
    {
        $answer = $user->forumAnswers()->create([
            'text' => $text,
            'images' => [],
            'forum_question_id' => $forumQuestionId
        ]);

        $answer->images = $this->saveFiles($images, 'forum', 'answer', $answer->id);
        $answer->save();

        (new YandexGPTService())->moderateText($answer->text, $answer);

        return $answer;
    }
}
