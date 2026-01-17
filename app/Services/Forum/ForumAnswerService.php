<?php

namespace App\Services\Forum;

use Illuminate\Support\Facades\Storage;
use App\Services\YandexGPTService;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ModerationTrait;

use App\Models\Forum\ForumAnswer;
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

    /**
     * Update the specified resource in storage.
     */
    public function update(ForumAnswer $answer, string $text, array|null $images)
    {
        if ($answer->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $data = ['text' => $text];

        if ($images)
            $data['images'] = $this->saveFiles($images, 'forum', 'answer', $answer->id);

        $moderation = $answer->moderations()->create(['data' => $data]);
        $moderation->moderation_status_id = 1;
        $this->acceptModeration(true, $moderation);

        //(new YandexGPTService())->moderateText($answer->text, $answer);

        return $answer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumAnswer $answer)
    {
        $images = [];
        $images = array_merge($images, $answer->images);

        foreach ($answer->moderations()->where('moderation_status_id', 1)->get() as $moderation)
            if (array_key_exists('images', $moderation->data)) $images = array_merge($images, $moderation->data['images']);

        Storage::disk('public')->delete($images);

        $answer->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);
        $answer->delete();
    }
}
