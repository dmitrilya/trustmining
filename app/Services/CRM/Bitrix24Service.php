<?php

namespace App\Services\CRM;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Bitrix24Service extends BaseCRMService
{
    /**
     * Получение access token по auth code
     */
    public function getAccessToken(string $domain, string $code): string
    {
        return 'string';
    }
}
