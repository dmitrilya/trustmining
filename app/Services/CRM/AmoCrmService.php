<?php

namespace App\Services\CRM;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AmoCRMService extends BaseCRMService
{
    protected string $integrationId;
    protected string $integrationSecret;
    protected string $channelId;
    protected string $channelSecret;

    public function __construct()
    {
        $this->integrationId = config('services.amocrm.integration.id');
        $this->integrationSecret = config('services.amocrm.integration.secret_key');
        $this->channelId = config('services.amocrm.channel.id');
        $this->channelSecret = config('services.amocrm.channel.secret_key');
    }

    /**
     * Получение access token по auth code
     */
    public function getAccessToken(string $domain, string $code): string
    {
        $endpoint = "oauth2/access_token";
        $body = [
            'client_id' => $this->integrationId,
            'client_secret' => $this->integrationSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => route('amocrm.auth'),
        ];

        $response = $this->sendSignedRequest($domain, 'POST', $endpoint, null, $body);

        return empty($response['access_token']) ? false : $response['access_token'];
    }

    /**
     * Получение amojo id
     */
    public function getAccountAmojoId(string $domain, string $accessToken): string
    {
        $endpoint = "api/v4/account?with=amojo_id";

        $response = $this->sendSignedRequest($domain, 'GET', $endpoint, $accessToken);

        return empty($response['amojo_id']) ? false : $response['amojo_id'];
    }

    /**
     * Подключение канала к аккаунту amoCRM
     */
    public function connectChannelToAccount(string $accountId): string
    {
        $endpoint = "{$this->channelId}/connect";
        $body = [
            'account_id' => $accountId,
            'hook_api_version' => 'v2',
        ];

        $response = $this->sendSignedRequestAmojo('POST', $endpoint, $body);

        if (!empty($response['scope_id'])) {
            Log::info("✅ Connected account {$accountId} -> scope_id: {$response['scope_id']}");
        }

        return empty($response['scope_id']) ? false : $response['scope_id'];
    }

    /**
     * Универсальный метод отправки сообщений в amoCRM Chat API
     *
     * @param string $scopeId
     * @param string $conversationId
     * @param string $userId — ID клиента (или пользователя)
     * @param string|array $content — текст или массив файлов
     * @param bool $fromClient — true, если сообщение от клиента (создаёт "Неразобранное")
     * @param string|null $userName — имя клиента (опционально, используется при создании "Неразобранного")
     * 
     * Формат для файлов:
     * [
     *     [
     *         'type' => 'file|image|audio|video',
     *         'file_name' => 'example.png',
     *         'file_size' => 123456,
     *         'mime_type' => 'image/png',
     *         'file_url' => 'https://yourdomain.com/uploads/example.png',
     *     ],
     *     ...
     * ]
     */
    public function sendMessage(
        string $scopeId,
        int $conversationId,
        int $messageId,
        string $userId,
        string|array $content,
        bool $fromClient = false,
        ?string $userName = null,
        ?string $userEmail = null,
    ): array {
        $endpoint = "{$scopeId}/messages";
        $responses = [];

        // Определяем блок отправителя/получателя
        $direction = $fromClient
            ? ['sender' => ['id' => $userId, 'name' => $userName ?? 'Клиент', 'profile' => ['email' => $userEmail]], 'silent' => false]
            : ['sender' => ['ref_id' => $this->integrationId, 'name' => 'Bot'], 'recipient' => ['id' => $userId], 'silent' => true];

        // 1️⃣ Текстовое сообщение
        if (is_string($content)) {
            $timestamp = time();

            $body = [
                [
                    'event_type' => 'new_message',
                    'payload' => array_merge($direction, [
                        'timestamp' => $timestamp,
                        'conversation_id' => $conversationId,
                        'msgid' => $messageId,
                        'message' => [
                            'type' => 'text',
                            'text' => $content,
                        ],
                    ]),
                ],
            ];

            $responses[] = $this->sendSignedRequestAmojo('POST', $endpoint, $body);
        }

        // 2️⃣ Файловые сообщения
        if (is_array($content)) {
            foreach ($content as $file) {
                foreach (['type', 'file_name', 'file_size', 'mime_type', 'file_url'] as $key) {
                    if (empty($file[$key])) {
                        throw new \InvalidArgumentException("Missing required file data key: {$key}");
                    }
                }

                $messageId = uniqid('msg_', true);
                $timestamp = time();

                $message = [
                    'id' => $messageId,
                    'type' => $file['type'],
                    'timestamp' => $timestamp,
                    'file_name' => $file['file_name'],
                    'file_size' => (int)$file['file_size'],
                    'mime_type' => $file['mime_type'],
                    'file_url' => $file['file_url'],
                ];

                if (!empty($file['preview_url'])) {
                    $message['preview_url'] = $file['preview_url'];
                }

                $body = [
                    [
                        'event_type' => 'new_message',
                        'payload' => array_merge($direction, [
                            'conversation_id' => $conversationId,
                            'message' => $message,
                        ]),
                    ],
                ];

                $responses[] = $this->sendSignedRequestAmojo('POST', $endpoint, $body);
            }
        }

        return $responses;
    }


    /**
     * 📬 Сообщение доставлено
     */
    public function sendMessageDelivered(string $scopeId, string $conversationId, string $messageId): array
    {
        $endpoint = "{$scopeId}/messages";
        $timestamp = time();

        $body = [
            [
                'event_type' => 'message_delivered',
                'payload' => [
                    'timestamp' => $timestamp,
                    'conversation_id' => $conversationId,
                    'message' => [
                        'id' => $messageId,
                    ],
                ],
            ],
        ];

        return $this->sendSignedRequestAmojo('POST', $endpoint, $body);
    }

    /**
     * 👁️ Сообщение прочитано
     */
    public function sendMessageRead(string $scopeId, string $conversationId, string $messageId): array
    {
        $endpoint = "{$scopeId}/messages";
        $timestamp = time();

        $body = [
            [
                'event_type' => 'message_read',
                'payload' => [
                    'timestamp' => $timestamp,
                    'conversation_id' => $conversationId,
                    'message' => [
                        'id' => $messageId,
                    ],
                ],
            ],
        ];

        return $this->sendSignedRequestAmojo('POST', $endpoint, $body);
    }

    /**
     * Вспомогательный метод формирования подписанного запроса
     */
    protected function sendSignedRequest(string $domain, string $method, string $endpoint, ?string $accessToken, ?array $body = null): array
    {
        $url = "https://$domain/$endpoint";
        
        $contentType = 'application/json';
        $headers = [
            'Content-Type' => $contentType,
            'Authorization: Bearer' => $accessToken
        ];

        $request = Http::withHeaders($headers);

        if ($body) {
            $jsonBody = json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $request = $request->withBody($jsonBody, $contentType);
        }
            
        $response = $request->send($method, $url);

        if (!$response->successful()) {
            throw new \Exception("AmoCRM API Error: " . $response->body());
        }

        return $response->json();
    }

    /**
     * Вспомогательный метод формирования подписанного запроса к amojo
     */
    protected function sendSignedRequestAmojo(string $method, string $endpoint, array $body): array
    {
        $url = "https://amojo.amocrm.ru/v2/origin/custom/$endpoint";

        $jsonBody = json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $contentType = 'application/json';
        $date = gmdate('D, d M Y H:i:s T');
        $contentMd5 = base64_encode(md5($jsonBody, true));

        $stringToSign = "{$method}\n{$contentMd5}\n{$contentType}\n{$date}\n{$endpoint}";
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $this->secretKey, true));
        $xSignature = "{$this->integrationId}:{$signature}";

        $headers = [
            'Date' => $date,
            'Content-Type' => $contentType,
            'Content-MD5' => $contentMd5,
            'X-Signature' => $xSignature,
        ];

        $response = Http::withHeaders($headers)
            ->withBody($jsonBody, $contentType)
            ->send($method, $url);

        if (!$response->successful()) {
            throw new \Exception("AmoCRM API Amojo Error: " . $response->body());
        }

        return $response->json();
    }
}
