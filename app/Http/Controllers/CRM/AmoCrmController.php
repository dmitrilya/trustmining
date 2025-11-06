<?php

namespace App\Http\Controllers\CRM;

use Illuminate\Http\Request;

use App\Models\CRMSystem;
use App\Models\CRMConnection;

use App\Services\CRM\AmoCRMService;

class AmoCRMController extends BaseController
{
    public function __construct(AmoCRMService $service)
    {
        parent::__construct($service);
    }

    /**
     * Авторизация аккаунта, получение amojo_id и получение scope_id
     */
    public function auth(Request $request)
    {
        $user = $request->user();

        if (!$user) return redirect()->route('profile')->withErrors(['forbidden' => __('Authorization error. Please try again later or contact support')]);

        $accessToken = $this->service->getAccessToken($request->referer, $request->code);

        if (!$accessToken) return redirect()->route('profile')->withErrors(['forbidden' => __('Authorization error. Please try again later or contact support')]);

        $amojoId = $this->service->getAccountAmojoId($request->referer, $accessToken);

        if (!$amojoId) return redirect()->route('profile')->withErrors(['forbidden' => __('Authorization error. Please try again later or contact support')]);

        $scopeId = $this->service->connectChannelToAccount($amojoId);

        if (!$scopeId) return redirect()->route('profile')->withErrors(['forbidden' => __('Authorization error. Please try again later or contact support')]);

        $user->crmConnections()->attach([
            'crm_system_id' => CRMSystem::where('name', 'Amo')->first()->id,
            'external_id' => $scopeId
        ]);

        return redirect()->route('profile')->withErrors(['success' => __('Authorization was successful')]);
    }
}