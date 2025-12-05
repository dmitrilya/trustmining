<?php

namespace App\Services\Forum;

use App\Services\YandexGPTService;
use App\Http\Traits\FileTrait;
use App\Models\User\User;

class ForumQuestionService
{
    use FileTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, string $theme, string $text, array|null $images)
    {
        $question = $user->forumQuestions()->create([
            'theme' => $theme,
            'text' => $text,
            'images' => [],
            'keywords' => []
        ]);

        $question->images = $this->saveFiles($images, 'forum', 'question', $question->id);
        $question->save();

        (new YandexGPTService())->classifyForumQuestion($question);

        return $question;
    }
}
