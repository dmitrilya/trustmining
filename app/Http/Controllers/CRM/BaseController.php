<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;

use App\Services\CRM\BaseCRMService;

abstract class BaseController extends Controller
{
    protected $service;

    public function __construct(BaseCRMService $service)
    {
        $this->service = $service;
    }

    // Общие методы для всех интеграций
}