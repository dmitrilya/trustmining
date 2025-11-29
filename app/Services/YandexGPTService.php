<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Jobs\GetYandexGPTOperation;
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
    public function moderateText(string $text)
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

        return $this->request('POST', "$this->baseLLM/completion", $params);
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

        return collect($result->predictions)
            ->sortByDesc('confidence')
            ->first();
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
                    'mode' => "DISABLED"
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

        GetYandexGPTOperation::dispatch($response->id, $folder, $id)->delay(now()->addMinutes(1));

        return;
    }


    /**
     * ---------------------------------------------------------
     * 4. Определение категории вопроса + список ключевых слов
     * ---------------------------------------------------------
     */
    public function classifyForumQuestion(string $title, string $content)
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
                    'text' => config('prompts.forum_classification')
                ],
                [
                    'role' => 'user',
                    'text' => "Заголовок: $title\n\nТекст вопроса: $content"
                ]
            ]
        ];

        return $this->request('POST', "$this->baseLLM/completion", $params);
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
