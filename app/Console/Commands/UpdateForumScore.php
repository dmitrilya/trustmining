<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\Forum\ForumScoreService;

use App\Models\User\User;

class UpdateForumScore extends Command
{
    protected $signature = 'forumscore:update';
    protected $description = 'Updating forum score';

    public function handle()
    {
        $users = User::whereHas('moderatedForumAnswers')
            ->select(['id', 'forum_score'])->with(['moderatedForumAnswers' => fn($q) => $q->select(['id', 'forum_question_id', 'user_id'])->withCount('likes')->with([
                'forumQuestion:id',
                'forumQuestion.moderatedForumAnswers' => fn($q2) => $q2->select(['id', 'forum_question_id'])->withCount('likes')
                    ->having('likes_count', '>', 0)->orderByDesc('likes_count')
            ])])->get();

        $service = new ForumScoreService();

        foreach ($users as $user) {
            $old = $user->forum_score;

            $user->forum_score = $service->calculateForUser($user);
            $user->save();

            if ($old != $user->forum_score)
                Log::channel('forum-score')->info('Forum score updated', [
                    'user_id'  => $user->id,
                    'old'      => $old,
                    'new'      => $user->forum_score,
                    'answers'  => $user->moderatedForumAnswers->count(),
                ]);
        }

        return Command::SUCCESS;
    }
}
