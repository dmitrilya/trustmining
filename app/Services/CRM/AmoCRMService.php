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
    protected string $botId;

    public function __construct()
    {
        $this->integrationId = config('services.amocrm.integration.id');
        $this->integrationSecret = config('services.amocrm.integration.secret_key');
        $this->channelId = config('services.amocrm.channel.id');
        $this->channelSecret = config('services.amocrm.channel.secret_key');
        $this->botId = config('services.amocrm.channel.bot_id');
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
    public function getAccountDataWithAmojoId(string $domain, string $accessToken): bool|array
    {
        $endpoint = "api/v4/account?with=amojo_id";

        $response = $this->sendSignedRequest($domain, 'GET', $endpoint, $accessToken);

        return empty($response['amojo_id']) ? false : $response;
    }

    /**
     * Подключение канала к аккаунту amoCRM
     */
    public function connectChannelToAccount(string $accountId): string
    {
        $endpoint = "/v2/origin/custom/{$this->channelId}/connect";
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
     * @param string $userId — ID отправителя
     * @param string $addresseeId — ID получателя
     * @param string|array $content — текст или массив файлов
     * @param string|null $messageId
     * @param bool $fromClient — true, если сообщение от клиента (создаёт "Неразобранное")
     * @param string|null $userName — имя клиента (опционально, используется при создании "Неразобранного")
     * @param string|null $userEmail — email клиента (опционально, используется при создании "Неразобранного")
     * 
     * Формат для файлов:
     * [
     *     [
     *         'type' => 'file|picture|audio|video',
     *         'file_name' => 'example.png',
     *         'file_size' => 123456,
     *         'media' => 'https://yourdomain.com/uploads/example.png',
     *     ],
     *     ...
     * ]
     */
    public function sendMessage(
        string $scopeId,
        int $conversationId,
        string $userId,
        string $addresseeId,
        string|array $content,
        ?int $messageId = null,
        bool $fromClient = false,
        ?string $userName = null,
        ?string $userEmail = null,
    ): array {
        $endpoint = "/v2/origin/custom/{$scopeId}";
        $timestamp = time();
        $responses = [];

        // Определяем блок отправителя/получателя
        $direction = $fromClient
            ? ['sender' => ['id' => "$userId", 'name' => $userName ?? 'Клиент', 'profile' => ['email' => $userEmail]], 'silent' => false]
            : ['sender' => ['id' => "$userId", 'ref_id' => '91314bae-d1e4-4eb4-aeb5-2df8baa3eade', 'name' => 'Bot'], 'recipient' => ['id' => "$addresseeId"], 'silent' => true];

        // 1️⃣ Текстовое сообщение
        if (is_string($content)) {
            $body = [
                'event_type' => 'new_message',
                'payload' => array_merge($direction, [
                    'timestamp' => $timestamp,
                    'conversation_id' => "$conversationId",
                    'msgid' => "$messageId",
                    'message' => [
                        'type' => 'text',
                        'text' => $content,
                    ],
                ]),
            ];

            $responses[] = $this->sendSignedRequestAmojo('POST', $endpoint, $body);
        }

        // 2️⃣ Файловые сообщения
        if (is_array($content)) {
            foreach ($content as $file) {
                foreach (['type', 'file_name', 'file_size', 'media'] as $key) {
                    if (empty($file[$key])) {
                        throw new \InvalidArgumentException("Missing required file data key: {$key}");
                    }
                }

                $body = [
                    'event_type' => 'new_message',
                    'payload' => array_merge($direction, [
                        'timestamp' => $timestamp,
                        'conversation_id' => "$conversationId",
                        'msgid' => $messageId . '_' . $file['file_name'],
                        'message' => $file,
                    ]),
                ];

                $responses[] = $this->sendSignedRequestAmojo('POST', $endpoint, $body);
            }
        }

        return $responses;
    }

    /**
     * Формирование Signature для проверки вебхука об отключении интеграции
     */
    public function uninstallSignature($accountId)
    {
        return hash_hmac('sha256', sprintf('%s|%s', $this->integration, $accountId), $this->integrationSecret);
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
            'Authorization' => "Bearer $accessToken"
        ];

        $request = Http::withHeaders($headers);

        if ($body) {
            $jsonBody = json_encode($body);
            $request = $request->withBody($jsonBody, $contentType);
        }

        $response = $request->send($method, $url);

        if (!$response->successful()) {
            throw new \Exception("AmoCRM API Error: " . $response->body());
        }

        return $response->json();
    }

    /**
     * Формирование X-Signature
     */
    public function signature(string $stringToSign): string
    {
        return strtolower(hash_hmac('sha1', $stringToSign, $this->channelSecret));
    }

    /**
     * Вспомогательный метод формирования подписанного запроса к amojo
     */
    protected function sendSignedRequestAmojo(string $method, string $endpoint, array $body): array
    {
        $url = "https://amojo.amocrm.ru$endpoint";

        $jsonBody = json_encode($body);
        $checkSum = md5($jsonBody);
        $contentType = 'application/json';
        $date = gmdate('D, d M Y H:i:s T');
        $stringToSign = "{$method}\n{$checkSum}\n{$contentType}\n{$date}\n{$endpoint}";

        $headers = [
            'Date' => $date,
            'Content-Type' => $contentType,
            'Content-MD5' => strtolower($checkSum),
            'X-Signature' => $this->signature($stringToSign),
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
