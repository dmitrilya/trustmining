<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\AdTrait;
use App\Http\Traits\ViewTrait;

use App\Models\User;
use App\Models\Office;

class ShopController extends Controller
{
    use AdTrait, ViewTrait;

    /**
     * @param  Illuminate\Http\Request;
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function shop(Request $request, User $user)
    {
        $ads = $this->getAds($request)->where('user_id', $user->id)->get();

        return view('shop.shop', compact('ads', 'user'));
    }

    /**
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function aboutCompany(User $user)
    {
        if (!$user->company || $user->company->moderation) return redirect()->route('company', ['user' => $user->url_name]);

        return view('company.show', ['company' => $user->company]);
    }

    /**
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function hosting(User $user)
    {
        if (!$user->hosting || $user->hosting->moderation) return redirect()->route('company', ['user' => $user->url_name]);

        $this->addView(request(), $user->hosting);

        return view('hosting.show', ['hosting' => $user->hosting]);
    }

    public function reviews(Request $request, User $user)
    {
        return view('reviews', [
            'auth' => $request->user(),
            'name' => $user->name,
            'type' => 'App\Models\User',
            'id' => $user->id,
            'reviews' => $user->reviews
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function offices(User $user)
    {
        return view('office.index', ['offices' => $user->offices()->where('moderation', false)->get()]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function office(User $user, Office $office)
    {
        if ($office->moderation) return redirect()->route('company.offices', ['user' => $user->url_name]);

        $this->addView(request(), $office);

        return view('office.show', ['office' => $office]);
    }
}
