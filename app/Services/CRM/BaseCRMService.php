<?php

namespace App\Services\CRM;

abstract class BaseCRMService
{
    abstract public function getAccessToken(string $domain, string $code): string;
}
