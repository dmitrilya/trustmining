<?php

namespace App\Services\Forum;

use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Storage;
use App\Services\YandexGPTService;
use App\Http\Traits\NotificationTrait;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ModerationTrait;

use App\Models\Forum\ForumQuestion;
use App\Models\User\User;

class ForumQuestionService
{
    use FileTrait, NotificationTrait, ModerationTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, string $theme, string $text, array|null $images)
    {
        $text = Purifier::clean(htmlspecialchars_decode($text), 'forum_default');

        if ($text === "") return;

        $question = $user->forumQuestions()->create([
            'theme' => $theme,
            'text' => $text,
            'images' => [],
            'keywords' => [],
            'similar_questions' => []
        ]);

        $question->images = $this->saveFiles($images, 'forum', 'question', $question->id);
        $question->save();

        $question->moderations()->create(['data' => $question->attributesToArray()]);

        (new YandexGPTService())->classifyForumQuestion($question);

        return $question;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ForumQuestion $question, string $text, array|null $images)
    {
        $text = Purifier::clean(htmlspecialchars_decode($text), 'forum_default');

        if ($text === "") return;

        $data = ['text' => $text];

        if ($images)
            $data['images'] = $this->saveFiles($images, 'forum', 'question', $question->id);

        $moderation = $question->moderations()->create(['data' => $data]);
        $moderation->moderation_status_id = 1;
        $this->acceptModeration(true, $moderation);

        //(new YandexGPTService())->moderateText($question->text, $question);

        return $question;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumQuestion $question)
    {
        $images = [];
        $images = array_merge($images, $question->images);

        foreach ($question->moderations()->where('moderation_status_id', 1)->get() as $moderation)
            if (array_key_exists('images', $moderation->data)) $images = array_merge($images, $moderation->data['images']);

        Storage::disk('public')->delete($images);

        $question->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);
        $question->delete();
    }

    /**
     * Поиск похожих вопросов
     */
    public function findSimilarQuestions(ForumQuestion $question): void
    {
        $similarQuestions = ForumQuestion::where('published', true)->whereNot('id', $question->id)
            ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
            ->select(['id', 'forum_subcategory_id', 'theme'])->selectRaw('JSON_LENGTH(keywords) AS total_keywords')
            ->selectRaw("(SELECT COUNT(*) FROM JSON_TABLE(? , '$[*]' COLUMNS (kw VARCHAR(255) PATH '$')) AS s
            WHERE JSON_CONTAINS(forum_questions.keywords, JSON_QUOTE(s.kw))
        ) AS matches", [json_encode($question->keywords)])->havingRaw('matches / total_keywords >= ?', [0.75])
            ->orderByDesc('matches')->limit(5)->pluck('id');

        if (count($similarQuestions)) {
            $question->similar_questions = $similarQuestions;
            $question->save();
            $this->notify('Similar questions', collect([$question->user]), 'App\Models\Forum\ForumQuestions', $question);
        } elseif (!$question->moderation) {
            $question->published = true;
            $question->save();
        }        
    }

    /**
     * Опубликовать вопрос после просмотра похожих вопросов
     */
    public function publish(ForumQuestion $question): void
    {
        $question->published = true;
        $question->save();
    }
}
