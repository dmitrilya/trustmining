<?php

namespace App\Http\Controllers\CRM;

use Illuminate\Http\Request;

use App\Models\CRM\CRMSystem;

use App\Services\CRM\AmoCRMService;

class AmoCRMController extends BaseController
{
    /**
     * The CRM system model.
     *
     * @var \App\Models\CRM\CRMSystem
     */
    protected CRMSystem $crmSystem;

    /**
     * @return \App\Services\CRM\AmoCRMService
     */
    protected function amoService(): AmoCRMService
    {
        return $this->service;
    }

    /**
     * AmoCRMController constructor.
     *
     * @param \App\Services\CRM\AmoCRMService  $service
     * @return void
     */
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

        $accountData = $this->amoService()->getAccountDataWithAmojoId($request->referer, $accessToken);
        if (!$accountData) return redirect()->route('profile')->withErrors($this->authError);

        $scopeId = $this->amoService()->connectChannelToAccount($accountData['amojo_id']);
        if (!$scopeId) return redirect()->route('profile')->withErrors($this->authError);

        $user->crmConnections()->create([
            'crm_system_id' => $this->crmSystem->id,
            'account_id' => $accountData['id'],
            'external_id' => $scopeId
        ]);

        return redirect()->route('profile')->withErrors(['success' => __('Authorization was successful')]);
    }

    /**
     * Получение вебхука об отключении интеграции
     */
    public function handleUninstallWebhook(Request $request)
    {
        if (!$request->client_uuid || $request->client_uuid != $this->amoService()->getAppId())
            throw new \Exception('Invalid hook signature');

        if (!hash_equals($this->amoService()->uninstallSignature($request->account_id), $request->signature))
            throw new \Exception('Invalid hook signature');

        $this->crmSystem->crmConnections()->where('account_id', $request->account_id)->delete();

        return 'OK';
    }
}
