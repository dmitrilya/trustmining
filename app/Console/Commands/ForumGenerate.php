<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

use App\Models\Forum\ForumAnswer;
use App\Models\Forum\ForumComment;
use App\Models\Forum\ForumQuestion;
use App\Models\Forum\ForumSubcategory;

class ForumGenerate extends Command
{
    protected $signature = 'forum:generate';

    protected $description = 'Publish a random prepared forum message from forum.json';

    /**
     * Базовая вероятность публикации.
     *
     * 1 / 1440 ≈ одно сообщение в сутки.
     */
    private const BASE_PROBABILITY = 1 / 1440;

    /**
     * Максимальная вероятность публикации за один запуск.
     */
    private const MAX_PROBABILITY = 0.02;

    /**
     * Как сильно влияет количество доступных сообщений каждого типа на выбор выкладывать что-то или нет
     */
    private const QUESTION_ACTIVITY_WEIGHT = 1;
    private const ANSWER_ACTIVITY_WEIGHT   = 2;
    private const COMMENT_ACTIVITY_WEIGHT  = 3;

    /**
     * Как сильно влияет количество доступных сообщений каждого типа на выбор что именно выкладывать
     */
    private const QUESTION_SELECTION_WEIGHT  = 1;
    private const ANSWER_SELECTION_WEIGHT      = 2;
    private const COMMENT_SELECTION_WEIGHT  = 3;

    public function handle(): int
    {
        $path = base_path('forum.json');

        if (!file_exists($path)) {
            Log::channel('forum-generate')->warning('File forum.json not found');

            return self::FAILURE;
        }

        $json = file_get_contents($path);

        if ($json === false) {
            Log::channel('forum-generate')->warning('Unable to read forum.json');

            return self::FAILURE;
        }

        try {
            $forum = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            Log::channel('forum-generate')->warning('forum.json contains invalid JSON: ' . $e->getMessage());

            return self::FAILURE;
        }

        if (!is_array($forum)) {
            Log::channel('forum-generate')->warning('forum.json root must be an array');

            return self::FAILURE;
        }

        try {
            $this->validatePublishedEntities($forum);
        } catch (Throwable $e) {
            Log::channel('forum-generate')->warning('Validation error: ' . $e->getMessage());

            return self::FAILURE;
        }

        $available = $this->getAvailableMessages($forum);

        $questionsCount = count($available['questions']);
        $answersCount = count($available['answers']);
        $commentsCount = count($available['comments']);

        $totalAvailable = $questionsCount * self::QUESTION_ACTIVITY_WEIGHT + $answersCount * self::ANSWER_ACTIVITY_WEIGHT + $commentsCount * self::COMMENT_ACTIVITY_WEIGHT;

        if ($totalAvailable === 0) {
            Log::channel('forum-generate')->warning('Nothing available for publication');

            return self::SUCCESS;
        }

        $probability = $this->calculateProbability($totalAvailable);

        if (!$this->shouldPublish($probability)) return self::SUCCESS;

        $type = $this->chooseMessageType($questionsCount, $answersCount, $commentsCount);

        try {
            $published = match ($type) {
                'question' => $this->publishQuestion($forum, $available['questions'], $path),
                'answer' => $this->publishAnswer($forum, $available['answers'], $path),
                'comment' => $this->publishComment($forum, $available['comments'], $path),
                default => Log::channel('forum-generate')->warning("Unknown message type: {$type}"),
            };
        } catch (Throwable $e) {
            Log::channel('forum-generate')->warning('Publication failed: ' . $e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * Проверяет уже опубликованные элементы JSON.
     */
    private function validatePublishedEntities(array $forum): void
    {
        foreach ($forum as $questionIndex => $question) {
            if (isset($question['id'])) {
                $exists = ForumQuestion::query()->whereKey($question['id'])->exists();

                if (!$exists) Log::channel('forum-generate')->warning("Question ID {$question['id']} from " . "forum.json does not exist in database.");
            }

            if (!isset($question['id'])) continue;

            if (!isset($question['answers']) || !is_array($question['answers'])) continue;

            foreach ($question['answers'] as $answerIndex => $answer) {
                if (isset($answer['id'])) {
                    $exists = ForumAnswer::query()->whereKey($answer['id'])->where('forum_question_id', $question['id'])->exists();

                    if (!$exists) Log::channel('forum-generate')->warning("Answer ID {$answer['id']} from " . "forum.json does not exist in database " . "or belongs to another question.");
                }

                if (!isset($answer['id'])) continue;

                if (!isset($answer['comments']) || !is_array($answer['comments'])) continue;

                foreach ($answer['comments'] as $commentIndex => $comment) {
                    if (isset($comment['id'])) {
                        $exists = ForumComment::query()->whereKey($comment['id'])->where('forum_answer_id', $answer['id'])->exists();

                        if (!$exists) Log::channel('forum-generate')->warning("Comment ID {$comment['id']} from " . "forum.json does not exist in database " . "or belongs to another answer.");
                    }
                }
            }
        }
    }

    /**
     * Возвращает сообщения, которые сейчас доступны.
     */
    private function getAvailableMessages(array $forum): array
    {
        $available = [
            'questions' => [],
            'answers' => [],
            'comments' => [],
        ];

        foreach ($forum as $questionIndex => $question) {
            if (!isset($question['id'])) {
                $available['questions'][] = ['question_index' => $questionIndex];

                continue;
            }

            if (!isset($question['answers']) || !is_array($question['answers'])) continue;

            foreach ($question['answers'] as $answerIndex => $answer) {
                if (!isset($answer['id'])) {
                    $available['answers'][] = ['question_index' => $questionIndex, 'answer_index' => $answerIndex];

                    continue;
                }

                if (!isset($answer['comments']) || !is_array($answer['comments'])) continue;

                foreach ($answer['comments'] as $commentIndex => $comment) {
                    if (!isset($comment['id'])) $available['comments'][] = [
                        'question_index' => $questionIndex,
                        'answer_index' => $answerIndex,
                        'comment_index' => $commentIndex,
                    ];
                }
            }
        }

        return $available;
    }

    /**
     * Рассчитывает вероятность публикации.
     */
    private function calculateProbability(int $availableCount): float
    {
        $probability = self::BASE_PROBABILITY + ($availableCount / 600) * (self::MAX_PROBABILITY - self::BASE_PROBABILITY);

        return min($probability, self::MAX_PROBABILITY);
    }

    /**
     * Случайное решение — публиковать или пропустить.
     */
    private function shouldPublish(float $probability): bool
    {
        return (random_int(1, 1_000_000) / 1_000_000) <= $probability;
    }

    /**
     * Выбирает тип сообщения.
     *
     * Здесь используется количество доступных элементов
     * плюс коэффициент.
     *
     * Комментарии будут встречаться чаще, если их много.
     */
    private function chooseMessageType(int $questionsCount, int $answersCount, int $commentsCount): string
    {
        $weights = [];

        if ($questionsCount > 0) $weights['question'] = $questionsCount * self::QUESTION_SELECTION_WEIGHT;
        if ($answersCount > 0) $weights['answer'] = $answersCount * self::ANSWER_SELECTION_WEIGHT;
        if ($commentsCount > 0) $weights['comment'] = $commentsCount * self::COMMENT_SELECTION_WEIGHT;

        return $this->weightedRandom($weights);
    }

    /**
     * Взвешенный random.
     */
    private function weightedRandom(array $weights): string
    {
        $total = array_sum($weights);

        if ($total <= 0) Log::channel('forum-generate')->warning('Weighted random has no available options.');

        $random = random_int(1, $total);

        foreach ($weights as $key => $weight) {
            $random -= $weight;

            if ($random <= 0) return $key;
        }

        Log::channel('forum-generate')->warning('Unable to select weighted random item.');
    }

    /**
     * Создаёт вопрос.
     */
    private function publishQuestion(array &$forum, array $availableQuestions, string $path): ForumQuestion
    {
        $selected = $availableQuestions[array_rand($availableQuestions)];
        $questionIndex = $selected['question_index'];
        $questionData = &$forum[$questionIndex];

        if (isset($questionData['id'])) Log::channel('forum-generate')->warning('Selected question has already been published.');
        if (!isset($questionData['user_id'])) Log::channel('forum-generate')->warning("Question #{$questionIndex} has no user_id.");
        if (!isset($questionData['text'])) Log::channel('forum-generate')->warning("Question #{$questionIndex} has no text.");

        $question = ForumQuestion::create([
            'user_id' => $questionData['user_id'],
            'theme' => $questionData['theme'] ?? null,
            'text' => $questionData['text'],
            'keywords' => $questionData['keywords'] ?? [],
            'subcategory_id' => ForumSubcategory::where('name', $questionData['subcategory'])->value('id') ?? null,
        ]);

        $questionData['id'] = $question->id;

        try {
            $this->saveForum($path, $forum);
        } catch (Throwable $e) {
            try {
                $question->delete();
            } catch (Throwable $deleteException) {
                Log::channel('forum-generate')->warning('Unable to save forum.json AND unable ' . 'to rollback created question ID ' . $question->id . '. Original error: ' . $e->getMessage() . '. Delete error: ' . $deleteException->getMessage());
            }

            Log::channel('forum-generate')->warning('Unable to save forum.json. ' . 'Created question was rolled back. ' . $e->getMessage());
        }

        return $question;
    }

    /**
     * Создаёт ответ.
     */
    private function publishAnswer(array &$forum, array $availableAnswers, string $path): ForumAnswer
    {
        $selected = $availableAnswers[array_rand($availableAnswers)];
        $questionIndex = $selected['question_index'];
        $answerIndex = $selected['answer_index'];
        $questionData = &$forum[$questionIndex];
        $answerData = &$questionData['answers'][$answerIndex];

        if (!isset($questionData['id'])) Log::channel('forum-generate')->warning('Selected answer belongs to unpublished question.');
        if (isset($answerData['id'])) Log::channel('forum-generate')->warning('Selected answer has already been published.');
        if (!isset($answerData['user_id'])) Log::channel('forum-generate')->warning("Answer #{$answerIndex} has no user_id.");
        if (!isset($answerData['text'])) Log::channel('forum-generate')->warning("Answer #{$answerIndex} has no text.");

        $answer = ForumAnswer::create([
            'forum_question_id' => $questionData['id'],
            'user_id' => $answerData['user_id'],
            'text' => $answerData['text'],
        ]);

        $answerData['id'] = $answer->id;

        try {
            $this->saveForum($path, $forum);
        } catch (Throwable $e) {
            try {
                $answer->delete();
            } catch (Throwable $deleteException) {
                Log::channel('forum-generate')->warning('Unable to save forum.json AND unable ' . 'to rollback created answer ID ' . $answer->id . '. Original error: ' . $e->getMessage() . '. Delete error: ' . $deleteException->getMessage());
            }

            Log::channel('forum-generate')->warning('Unable to save forum.json. ' . 'Created answer was rolled back. ' . $e->getMessage());
        }

        return $answer;
    }

    /**
     * Создаёт комментарий.
     */
    private function publishComment(array &$forum, array $availableComments, string $path): ForumComment
    {
        $selected = $availableComments[array_rand($availableComments)];
        $questionIndex = $selected['question_index'];
        $answerIndex = $selected['answer_index'];
        $commentIndex = $selected['comment_index'];
        $questionData = &$forum[$questionIndex];
        $answerData = &$questionData['answers'][$answerIndex];
        $commentData = &$answerData['comments'][$commentIndex];

        if (!isset($questionData['id'])) Log::channel('forum-generate')->warning('Selected comment belongs to unpublished question.');
        if (!isset($answerData['id'])) Log::channel('forum-generate')->warning('Selected comment belongs to unpublished answer.');
        if (isset($commentData['id'])) Log::channel('forum-generate')->warning('Selected comment has already been published.');
        if (!isset($commentData['user_id'])) Log::channel('forum-generate')->warning("Comment #{$commentIndex} has no user_id.");
        if (!isset($commentData['text'])) Log::channel('forum-generate')->warning("Comment #{$commentIndex} has no text.");

        $comment = ForumComment::create([
            'forum_answer_id' => $answerData['id'],
            'user_id' => $commentData['user_id'],
            'text' => $commentData['text'],
        ]);

        $commentData['id'] = $comment->id;

        try {
            $this->saveForum($path, $forum);
        } catch (Throwable $e) {
            try {
                $comment->delete();
            } catch (Throwable $deleteException) {
                Log::channel('forum-generate')->warning('Unable to save forum.json AND unable ' . 'to rollback created comment ID ' . $comment->id . '. Original error: ' . $e->getMessage() . '. Delete error: ' . $deleteException->getMessage());
            }

            Log::channel('forum-generate')->warning('Unable to save forum.json. ' . 'Created comment was rolled back. ' . $e->getMessage());
        }

        return $comment;
    }

    /**
     * Сохраняет forum.json.
     */
    private function saveForum(string $path, array $forum): void
    {
        try {
            $json = json_encode($forum, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            Log::channel('forum-generate')->warning('Unable to encode forum.json: ' . $e->getMessage());
        }

        $temporaryPath =  $path . '.tmp';

        $result = file_put_contents($temporaryPath, $json . PHP_EOL, LOCK_EX);

        if ($result === false) Log::channel('forum-generate')->warning('Unable to write temporary forum.json file');

        if (!rename($temporaryPath, $path)) {
            @unlink($temporaryPath);

            Log::channel('forum-generate')->warning('Unable to replace forum.json');
        }
    }
}
