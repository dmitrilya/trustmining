<?php

namespace App\Http\Controllers\CRM;

use Illuminate\Http\Request;

use App\Models\CRMSystem;

use App\Services\CRM\AmoCRMService;

class AmoCRMController extends BaseController
{
    protected $crmSystem;

    public function __construct(AmoCRMService $service)
    {
        parent::__construct($service);

        $this->crmSystem = CRMSystem::where('name', 'AmoCRM')->first();
    }

    /**
     * Авторизация аккаунта, получение amojo_id и получение scope_id
     */
    public function auth(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->crmConnections()->where('crm_system_id', $this->crmSystem->id)->exists())
            return redirect()->route('profile')->withErrors($this->authError);

        $accessToken = $this->service->getAccessToken($request->referer, $request->code);
        if (!$accessToken) return redirect()->route('profile')->withErrors($this->authError);

        $amojoId = $this->service->getAccountAmojoId($request->referer, $accessToken);
        if (!$amojoId) return redirect()->route('profile')->withErrors($this->authError);

        $scopeId = $this->service->connectChannelToAccount($amojoId);
        if (!$scopeId) return redirect()->route('profile')->withErrors($this->authError);

        $user->crmConnections()->create([
            'crm_system_id' => $this->crmSystem->id,
            'external_id' => $scopeId
        ]);

        return redirect()->route('profile')->withErrors(['success' => __('Authorization was successful')]);
    }
}
