<?php

namespace App\Services\CRM;

class CRMServiceFactory
{
    public static function createService(string $type): BaseCRMService
    {
        switch ($type) {
            case 'AmoCRM':
                return new AmoCRMService();
            case 'Bitrix24':
                return new Bitrix24Service();
            default:
                throw new \InvalidArgumentException('Неизвестный тип сервиса');
        }
    }
}