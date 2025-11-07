<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;

use App\Services\CRM\BaseCRMService;

abstract class BaseController extends Controller
{
    protected $authError;
    protected $service;

    public function __construct(BaseCRMService $service)
    {
        $this->authError = ['forbidden' => __('Authorization error. Please try again later or contact support')];
        $this->service = $service;
    }

    // Общие методы для всех интеграций
}