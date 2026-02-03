<?php

namespace App\Services\Forum;

use Mews\Purifier\Facades\Purifier;
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
    public function store(User $user, string|null $text, array|null $images, array|null $files, int $forumQuestionId)
    {
        if ($text) $text = Purifier::clean(htmlspecialchars_decode($text), 'forum_default');

        if ((!$text || $text === "") && !$images && !$files) return;

        $answer = $user->forumAnswers()->create([
            'text' => $text,
            'images' => [],
            'files' => [],
            'forum_question_id' => $forumQuestionId
        ]);

        $answer->images = $this->saveFiles($images, 'forum', 'answer', $answer->id);
        $answer->files = $this->saveFilesWithName($files, 'forum', 'answer', $answer->id);
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
    public function update(ForumAnswer $answer, string|null $text, array|null $images, array|null $files)
    {
        if ($text) $text = Purifier::clean(htmlspecialchars_decode($text), 'forum_default');

        if ((!$text || $text === "") && !$images && !$files) return;

        $data = ['text' => $text];

        if ($images)
            $data['images'] = $this->saveFiles($images, 'forum', 'answer', $answer->id);
        if ($files)
            $data['files'] = $this->saveFilesWithName($files, 'forum', 'answer', $answer->id);

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
