<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Traits\ShopTrait;
use App\Http\Traits\ViewTrait;
use App\Http\Traits\AdTrait;
use App\Http\Traits\HostingTrait;
use App\Services\TrustFactorService;

use App\Models\User\User;
use App\Models\User\Office;

class ShopController extends Controller
{
    use ShopTrait, ViewTrait, AdTrait, HostingTrait;

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shops(Request $request)
    {
        return view('shop.index', ['shops' => $this->getShops($request)->orderByDesc('ordering_id')->get()]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function shop(Request $request, User $user)
    {
        $ads = $this->getAds(null, $request)->where('ads.user_id', $user->id)->paginate(150);

        return view('shop.show', compact('ads', 'user'));
    }

    /**
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function aboutCompany(User $user)
    {
        $auth = Auth::user();

        if (!$user->company || $user->company->moderation && !($auth && ($auth->id == $user->id || $auth->role->name != 'user')))
            return redirect()->route('company', ['user' => $user->slug]);

        return view('company.show', [
            'user' => $user,
            'company' => $user->company,
            'tfData' => (new TrustFactorService)->calculateDetailed($user)
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function hostings(Request $request, User $user)
    {
        $auth = Auth::user();

        if (!$user->tariff || !$user->hostings()->where('moderation', false)->count() && !($auth && ($auth->id == $user->id || $auth->role->name != 'user')))
            return redirect()->route('company', ['user' => $user->slug]);

        return view('shop.hostings', [
            'user' => $user,
            'hostings' => $this->getHostings($request)->where('user_id', $user->id)->get(),
        ]);
    }

    /**
     * @param  \App\Models\User\User  $user
     * @param  string  $hostingQuery
     * @return \Illuminate\Http\Response
     */
    public function hosting(User $user, string $hostingQuery)
    {
        $queryParts = explode('-', $hostingQuery);
        if (count($queryParts) < 2) abort(404);

        $hosting = $user->hostings()->where('id', end($queryParts))->first();
        if (!$hosting) abort(404);

        $auth = Auth::user();

        if (!$user->tariff || $hosting->moderation && !($auth && ($auth->id == $user->id || $auth->role->name != 'user')))
            return redirect()->route('company', ['user' => $user->slug]);

        $this->addView(request(), $user->hosting);

        return view('hosting.show', [
            'user' => $user,
            'hosting' => $hosting,
            'tfData' => (new TrustFactorService)->calculateDetailed($user)
        ]);
    }

    public function reviews(Request $request, User $user)
    {
        return view('review.index', [
            'auth' => $request->user(),
            'name' => $user->name,
            'type' => 'user',
            'id' => $user->id,
            'reviews' => $user->reviews
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function offices(User $user)
    {
        $limit = $user->tariff ? $user->tariff->max_offices : 1;

        return view('office.index', [
            'user' => $user,
            'offices' => $user->offices()->where('moderation', false)->limit($limit)->get(),
            'title' => __('meta.office.shop.title', ['name' => $user->name]),
            'description' => __('meta.office.shop.description', ['name' => $user->name]),
            'header' => __('Offices') . ' ' . $user->name,
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function office(User $user, Office $office)
    {
        $limit = $user->tariff ? $user->tariff->max_offices : 1;
        $officeIds = $user->offices()->where('moderation', false)->pluck('id')->toArray();

        if ($office->user->id != $user->id || $office->moderation || array_search($office->id, $officeIds) >= $limit)
            return redirect()->route('company.offices', ['user' => $user->slug]);

        $this->addView(request(), $office);

        return view('office.show', ['office' => $office]);
    }
}
