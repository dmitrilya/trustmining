<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Jobs\GetYandexGPTOperation;
use App\Models\Forum\ForumAnswer;
use App\Models\Forum\ForumComment;
use App\Models\Forum\ForumQuestion;
use Exception;

/**
 * Сервис для работы с YandexGPT API.
 * Обеспечивает классификацию текста, проверки документов и работу с async-операциями.
 */
class YandexGPTService
{
    /**
     * Базовые параметры API.
     */
    private string $apiKey;
    private string $folderId;

    private string $baseLLM = 'https://llm.api.cloud.yandex.net/foundationModels/v1';
    private string $baseOperation = 'https://operation.api.cloud.yandex.net/operations';

    public function __construct()
    {
        $this->apiKey   = config('services.yandexgpt.key');
        $this->folderId = config('services.yandexgpt.folder');
    }


    /**
     * ---------------------------------------------------------
     * 1. Модерация текста (вердикт + список причин)
     * ---------------------------------------------------------
     */
    public function moderateText(string $text, array $data)
    {
        $params = [
            'modelUri' => "gpt://{$this->folderId}/yandexgpt",
            'completionOptions' => [
                'stream' => false,
                'temperature' => 0.1,
                'maxTokens' => '800',
                'reasoningOptions' => ['mode' => 'DISABLED'],
            ],
            'messages' => [
                [
                    'role' => 'system',
                    'text' => config('prompts.moderation')
                ],
                [
                    'role' => 'user',
                    'text' => $text
                ]
            ]
        ];

        $response = $this->request('POST', "$this->baseLLM/completionAsync", $params);

        $fallbacks = [
            ['risk' => 50, 'reasons' => []],
            [
                'risk' => 100,
                'reasons' => $response->result->alternatives[0]->status
            ]
        ];

        GetYandexGPTOperation::dispatch($response->id, 'moderation', null, $fallbacks, $data)->delay(now()->addMinutes(1));

        return $response;
    }


    /**
     * ---------------------------------------------------------
     * 2. Анализ отзывов (few-shot), возвращает лучший вариант
     * ---------------------------------------------------------
     */
    public function checkReviewWithPrompt(string $text)
    {
        $params = [
            'modelUri' => "cls://{$this->folderId}/yandexgpt",
            'text' => $text,
            'task_description' => config('prompts.review_analysis'),
            'labels' => [
                'Фальшивый',
                'Настоящий',
                'Оскорбительный'
            ]
        ];

        $result = $this->request('POST', "$this->baseLLM/fewShotTextClassification", $params);

        if (!$result || !isset($result->predictions)) return null;

        return collect($result->predictions)->sortByDesc('confidence')->first();
    }


    /**
     * ---------------------------------------------------------
     * 3. Отправка документа (договор) на асинхронную проверку
     * ---------------------------------------------------------
     */
    public function checkDocument(string $text, string $folder, int $id)
    {
        $params = [
            'modelUri' => "gpt://{$this->folderId}/yandexgpt",
            'completionOptions' => [
                'stream' => false,
                'temperature' => 0.1,
                'maxTokens' => '2000',
                'reasoningOptions' => [
                    'mode' => 'DISABLED'
                ]
            ],
            'messages' => [
                [
                    'role' => 'system',
                    'text' => config('prompts.contract_analysis')
                ],
                [
                    'role' => 'user',
                    'text' => $text
                ]
            ]
        ];

        $response = $this->request('POST', "$this->baseLLM/completionAsync", $params);

        GetYandexGPTOperation::dispatch($response->id, $folder, $id)->delay(now()->addMinutes(2));

        return $response;
    }


    /**
     * ---------------------------------------------------------
     * 4. Определение категории вопроса + список ключевых слов
     * ---------------------------------------------------------
     */
    public function classifyForumQuestion(ForumQuestion $question)
    {
        $params = [
            'modelUri' => "gpt://{$this->folderId}/yandexgpt",
            'completionOptions' => [
                'stream' => false,
                'temperature' => 0.1,
                'maxTokens' => '800',
                'reasoningOptions' => [
                    'mode' => 'DISABLED'
                ],
            ],
            'messages' => [
                [
                    'role' => 'system',
                    'text' => config('prompts.forum_classification')
                ],
                [
                    'role' => 'user',
                    'text' => "Заголовок: $question->theme\n\nТекст вопроса: $question->text"
                ]
            ]
        ];

        $response = $this->request('POST', "$this->baseLLM/completionAsync", $params);

        GetYandexGPTOperation::dispatch($response->id, 'forum-question')->delay(now()->addMinutes(1));

        return $response;
    }


    /**
     * ---------------------------------------------------------
     * Получение результата async-операции YandexGPT
     * ---------------------------------------------------------
     */
    public function getOperation(string $id)
    {
        $operation = $this->request('GET', "{$this->baseOperation}/$id");

        if (!$operation) return false;

        // операция ещё не завершена — отправляем повторную попытку
        if (!$operation->done) {
            return GetYandexGPTOperation::dispatch($id)
                ->delay(now()->addMinutes(1));
        }

        // есть результат
        if (isset($operation->response)) {
            return $operation->response;
        }

        return false;
    }


    /**
     * ---------------------------------------------------------
     * Безопасный парсер JSON из текста ответа модели.
     * ---------------------------------------------------------
     */
    public function parseJsonSafe(string $text, array $fallback = []): array
    {
        $data = json_decode($text, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            return $data;
        }

        if (preg_match('/\{.*\}/s', $text, $matches)) {
            $data = json_decode($matches[0], true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                return $data;
            }
        }

        return $fallback;
    }


    /**
     * ---------------------------------------------------------
     * Универсальный метод для отправки запросов к API YandexGPT
     * ---------------------------------------------------------
     */
    private function request(string $method, string $url, array|null $params = null)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Api-Key ' . $this->apiKey,
            'Content-Type'  => 'application/json',
            'x-folder-id'   => $this->folderId,
        ])->acceptJson();

        $response = match ($method) {
            'POST' => $response->post($url, $params),
            'GET'  => $response->get($url),
            default => throw new \Exception("Unsupported HTTP method: $method"),
        };

        if ($response->failed()) {
            info('YandexGPT HTTP Error: ' . $response->status() . ' ' . $response->body());
            return null;
        }

        return $response->object();
    }
}
