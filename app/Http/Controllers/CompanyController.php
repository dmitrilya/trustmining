<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Http\Request;

use App\Models\Moderation;
use App\Models\Passport;
use App\Models\Company;

class CompanyController extends Controller
{
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

        $company = Company::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
            'card' => [],
            'documents' => [],
        ]);

        $company->logo = $this->saveFile($request->file('logo'), 'companies', 'logo', $company->id);
        $company->documents = $this->saveFiles($request->file('documents'), 'companies', 'doc', $company->id);
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
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
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
