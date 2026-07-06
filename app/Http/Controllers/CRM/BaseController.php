<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;

use App\Services\CRM\BaseCRMService;

abstract class BaseController extends Controller
{
    /**
     * Authorization error message.
     *
     * @var array
     */
    protected array $authError;

    /**
     * Service.
     *
     * @var \App\Services\CRM\BaseCRMService
     */
    protected BaseCRMService $service;

    /**
     * AmoCRMController constructor.
     *
     * @param \App\Services\CRM\BaseCRMService  $service
     * @return void
     */
    public function __construct(BaseCRMService $service)
    {
        $this->authError = ['forbidden' => __('Authorization error. Please try again later or contact support')];
        $this->service = $service;
    }
}