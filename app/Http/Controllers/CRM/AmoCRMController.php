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

        $accountData = $this->service->getAccountDataWithAmojoId($request->referer, $accessToken);
        if (!$accountData) return redirect()->route('profile')->withErrors($this->authError);

        $scopeId = $this->service->connectChannelToAccount($accountData['amojo_id']);
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
        if (!$request->client_uuid || $request->client_uuid != $this->service->integrationId)
            throw new \Exception('Invalid hook signature');

        if (!hash_equals($this->service->uninstallSignature($request->account_id), $request->signature))
            throw new \Exception('Invalid hook signature');

        $this->crmSystem->crmConnections()->where('account_id', $request->account_id)->delete();

        return 'OK';
    }
}
