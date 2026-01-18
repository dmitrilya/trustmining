<?php

namespace App\Services\Forum;

use App\Models\User\User;

class ForumScoreService
{
    /**
     * Посчитать forum_score для пользователя
     */
    public function calculateForUser(User $user)
    {
        $score = 0;

        foreach ($user->moderatedForumAnswers as $answer) {
            $score++;
            $score += 10 * $answer->likes_count;

            if ($answer->forumQuestion->moderatedForumAnswers->count() && $answer->id == $answer->forumQuestion->moderatedForumAnswers->first()->id)
                $score += 50;
        }

        return $score;
    }
}
