<?php

namespace App\Http\Controllers;

use MoveMoveIo\DaData\Facades\DaDataCompany;

use App\Http\Traits\FileTrait;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;

use App\Models\Moderation;
use App\Models\Passport;
use App\Models\Company;

class CompanyController extends Controller
{
    use FileTrait;

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

        if (!$user->passport) {
            $passport = Passport::create([
                'user_id' => $user->id,
                'images' => [],
            ]);

            $passport->images = $this->saveFiles($request->file('images'), 'passports', 'image', $passport->id, 'private/');
            $passport->save();

            Moderation::create([
                'moderationable_type' => 'App\Models\Passport',
                'moderationable_id' => $passport->id,
                'data' => $passport->attributesToArray()
            ]);
        }

        $suggs = DaDataCompany::id($request->inn)['suggestions'];

        if (!count($suggs)) return back()->withErrors(['forbidden' => __('Not available company.')]);

        $compnayInfo = $suggs[0];

        $company = Company::create([
            'user_id' => $user->id,
            'name' => $compnayInfo['value'],
            'card' => $compnayInfo['data'],
            'documents' => [],
            'images' => [],
        ]);

        $company->documents = $this->saveFilesWithName($request->file('documents'), 'companies', 'doc', $company->id);
        $company->save();

        Moderation::create([
            'moderationable_type' => 'App\Models\Company',
            'moderationable_id' => $company->id,
            'data' => $company->attributesToArray()
        ]);

        return redirect()->route('profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        if (\Auth::user()->id != $company->user->id || $company->moderation)
            return back()->withErrors(['forbidden' => __('Unavailable company.')]);

        if ($company->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $user = \Auth::user();

        if ($user->id != $company->user->id || $company->moderation)
            return back()->withErrors(['forbidden' => __('Unavailable company.')]);

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

        if (!empty($data))
            Moderation::create([
                'moderationable_type' => 'App\Models\Company',
                'moderationable_id' => $company->id,
                'data' => $data
            ]);

        return redirect()->route('company.about', ['user' => $user->url_name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
