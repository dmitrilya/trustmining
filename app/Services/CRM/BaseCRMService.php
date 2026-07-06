<?php

namespace App\Services\CRM;

abstract class BaseCRMService
{
    abstract public function getAccessToken(string $domain, string $code): string;

    abstract public function sendMessage(
        string $scopeId,
        int $conversationId,
        string $userId,
        string $addresseeId,
        string|array $content,
        ?int $messageId = null,
        bool $fromClient = false,
        ?string $userName = null,
        ?string $userEmail = null,
    ): array;
}
