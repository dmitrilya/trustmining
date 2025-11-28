<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;

use App\Http\Traits\FileTrait;
use App\Http\Traits\DaData;
use App\Http\Traits\Tinkoff;
use App\Jobs\CheckInvoice;
use App\Models\Morph\Moderation;
use App\Models\User\Company;
use App\Models\User\Order;

class CompanyController extends Controller
{
    use FileTrait, DaData, Tinkoff;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->company) return redirect()->route('profile');

        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $user = $request->user();

        if ($user->company) return redirect()->route('profile');

        if (Company::whereJsonContains('card->inn', $request->inn)->exists()) return back()->withErrors(['forbidden' => __('Check the entered TIN')]);

        $card = $this->dadataCompanyByInn($request->inn);

        if (!$card) return back()->withErrors(['forbidden' => __('Check the entered TIN')]);

        $company = Company::create([
            'user_id' => $user->id,
            'name' => $card['value'],
            'card' => $card['data'],
            'documents' => [],
            'images' => [],
        ]);

        //$company->documents = $this->saveFilesWithName($request->file('documents'), 'companies', 'doc', $company->id);
        //$company->save();

        $order = Order::create([
            'user_id' => $user->id,
            'amount' => 10,
            'method' => 'invoice_verification'
        ]);

        $res = $this->invoice($order);

        $order->invoice_id = $res->invoiceId;
        $order->invoice_url = $res->pdfUrl;
        $order->save();

        //CheckInvoice::dispatch($order)->delay(now()->addMinutes(15));

        return redirect()->route('profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        if ($company->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCompanyRequest  $request
     * @param  \App\Models\User\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $user = \Auth::user();

        if ($company->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $data = [];

        if ($user->tariff && $user->tariff->can_site_link && $request->site != $company->site) $data['site'] = $request->site;
        if ($request->description != $company->description) $data['description'] = $request->description;
        if ($request->video != $company->video) $data['video'] = $request->video;

        if ($request->images)
            $data['images'] = $this->saveFiles($request->file('images'), 'companies', 'image', $company->id);

        if ($request->logo)
            $data['logo'] = $this->saveFile($request->file('logo'), 'companies', 'logo', $company->id);

        if ($request->bg_logo)
            $data['bg_logo'] = $this->saveFile($request->file('bg_logo'), 'companies', 'bg_logo', $company->id);

        if (!empty($data))
            Moderation::create([
                'moderationable_type' => 'App\Models\User\Company',
                'moderationable_id' => $company->id,
                'data' => $data
            ]);

        return redirect()->route('company.about', ['user' => $user->url_name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
