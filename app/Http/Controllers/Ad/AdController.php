<?php

namespace App\Http\Controllers\Ad;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;

use App\Http\Traits\ViewTrait;
use App\Http\Traits\AdTrait;

use App\Services\AdService;

use App\Models\Ad\Ad;
use App\Models\Ad\AdCategory;
use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Database\GPUBrand;
use App\Models\Database\GPUModel;
use App\Models\Database\Coin;

class AdController extends Controller
{
    use ViewTrait, AdTrait;

    protected $service;

    public function __construct(AdService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @param  \App\Models\Ad\AdCategory  $adCategory;
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AdCategory $adCategory)
    {
        $ads = $this->getAds($request, $adCategory)->orderByDesc('ads.ordering_id')->paginate(15)->withQueryString();

        if ($request->ajax()) return response()->json([
            'html' => view('ad.components.list', ['adCategory' => $adCategory, 'ads' => $ads, 'user' => $request->user(), 'owner' => false])->render(),
            'hasMore' => $ads->hasMorePages()
        ]);

        return view('ad.index', [
            'ads' => $ads,
            'adCategory' => $adCategory
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @param  \App\Models\Ad\AdCategory  $adCategory;
     * @return \Illuminate\Http\Response
     */
    public function getAdsCarousel(Request $request, AdCategory $adCategory)
    {
        $ads = $this->getAds($request, $adCategory)->orderByDesc('ads.ordering_id')->paginate(4);

        if ($request->ajax()) return response()->json([
            'html' => view('home.components.carousel-list', [
                'adCategory' => $adCategory,
                'items' => $ads,
                'blade' => 'ad.components.card',
                'model' => 'ad',
                'user' => $request->user(),
                'owner' => false
            ])->render(),
            'hasMore' => $ads->hasMorePages()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /** @var \App\Models\User\User $user */
        $user = Auth::user();

        if ($user->tariff && $user->ads()->count() >= $user->tariff->max_ads || !$user->tariff && $user->ads()->count() >= 2)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        return view('ad.create', [
            'models' => AsicModel::select(['id', 'name', 'slug'])->with('asicVersions:id,asic_model_id,hashrate')->get(),
            'gpuModels' => GPUModel::select(['id', 'name', 'slug', 'max_power', 'gpu_brand_id', 'gpu_engine_model_id'])
                ->with(['gpuBrand:id,name', 'gpuEngineModel:id,name,gpu_engine_brand_id', 'gpuEngineModel.gpuEngineBrand:id,name'])->get(),
            'offices' => $user->offices()->select(['id', 'address'])->get(),
            'coins' => Coin::where('paymentable', true)->select(['id', 'abbreviation'])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdRequest $request)
    {
        $user = $request->user();
        $activeAdsCount = $user->activeAds()->count();
        $maxAds = $user->tariff?->max_ads ?? config('settings.ads.max_count_without_tariff');

        if ($activeAdsCount >= $maxAds) return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $this->service->store($request->validated(), $request->file('images'), $request->file('preview'), $user);

        return redirect()->route('company', ['user' => $user->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad\AdCategory  $adCategory
     * @param  \App\Models\Ad\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(AdCategory $adCategory, Ad $ad)
    {
        $user = Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $ad->user_id) && ($ad->moderation || $ad->hidden))
            return back()->withErrors(['forbidden' => __('Unavailable ad.')]);

        if (!$user || $user->id != $ad->user_id) {
            $this->addView(request(), $ad);
            if ($adCategory->name == 'miners') $this->addView(request(), $ad->asicVersion->asicModel);
            elseif ($adCategory->name == 'gpus') $this->addView(request(), $ad->gpuModel);
        }

        $ads = [];

        if ($adCategory->name == 'miners') {
            $ad->version_data = Cache::get('calculator_models')->where('id', $ad->asicVersion->asicModel->id)->first()?->asicVersions->where('id', $ad->asic_version_id)->first();
            $ads = $this->getAds()->whereIn('ads.asic_version_id', $ad->asicVersion->asicModel->asicVersions()->pluck('id'))
                ->limit(9)->get();
        }

        return view('ad.show', [
            'ad' => $ad,
            'ads' => $ads,
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @param  \App\Models\Database\AsicModel  $asicModel
     * @param  string  $asicVersion
     * @param  string  $ad
     * @return \Illuminate\Http\Response
     */
    public function asicMinerAd(AsicBrand $asicBrand, AsicModel $asicModel, string $asicVersion, $ad)
    {
        $ad = Ad::find(array_reverse(explode('-', $ad))[0]);
        if (!$ad) abort(404);

        $user = Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $ad->user_id) && ($ad->moderation || $ad->hidden))
            return back()->withErrors(['forbidden' => __('Unavailable ad.')]);

        $this->addView(request(), $ad);

        $ad->version_data = Cache::get('calculator_models')->where('id', $ad->asicVersion->asicModel->id)->first()?->asicVersions->where('id', $ad->asic_version_id)->first();
        $ads = $this->getAds()->whereIn('ads.asic_version_id', $ad->asicVersion->asicModel->asicVersions()->pluck('id'))
            ->limit(9)->get();

        return view('ad.show', [
            'ad' => $ad,
            'ads' => $ads,
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @param  \App\Models\Database\GPUModel  $gpuModel
     * @param  string  $ad
     * @return \Illuminate\Http\Response
     */
    public function gpuAd(GPUBrand $gpuBrand, GPUModel $gpuModel, $ad)
    {
        $ad = Ad::find(array_reverse(explode('-', $ad))[0]);
        if (!$ad) abort(404);

        $user = Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $ad->user_id) && ($ad->moderation || $ad->hidden))
            return back()->withErrors(['forbidden' => __('Unavailable ad.')]);

        $this->addView(request(), $ad);

        return view('ad.show', [
            'ad' => $ad,
            'ads' => [],
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        /** @var \App\Models\User\User $user */
        $user = Auth::user();

        if ($ad->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        return view('ad.edit', [
            'ad' => $ad,
            'offices' => $user->offices()->where('moderation', false)->select(['id', 'address'])->get(),
            'coins' => Coin::where('paymentable', true)->select(['id', 'abbreviation'])->get()
        ]);
    }

    /**
     * Show the form for editing listings of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editMass(Request $request)
    {
        return view('ad.edit-mass', [
            'ads' => $request->user()->ads()->where('ad_category_id', 1)->where('moderation', false)
                ->with(['office:id,city_id', 'office.cityRelation:id,name', 'coin:id,abbreviation', 'asicVersion:id,hashrate,measurement,asic_model_id', 'asicVersion.asicModel:id,name'])
                ->orderBy('props->Availability')->orderBy('props->Condition')->join('asic_versions', 'ads.asic_version_id', '=', 'asic_versions.id')
                ->join('asic_models', 'asic_versions.asic_model_id', '=', 'asic_models.id')->orderBy('asic_models.name')
                ->orderBy('asic_versions.hashrate')->select('ads.*')->get(),
            'coins' => Coin::where('paymentable', true)->select(['id', 'abbreviation'])->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdRequest  $request
     * @param  \App\Models\Ad\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdRequest $request, Ad $ad)
    {
        if ($ad->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $this->service->update($ad, $request->validated(), $request->file('images'), $request->file('preview'));

        return redirect()->route('ads.show', ['adCategory' => $ad->adCategory->name, 'ad' => $ad->id]);
    }

    /**
     * Update listing of the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMass(Request $request)
    {
        $this->service->updateMass($request->changings, $request->user());

        return response()->json(['success' => true, 'message' => __('Prices successfully updated')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $user = Auth::user();

        $files = [];
        array_push($files, $ad->preview);
        $files = array_merge($files, $ad->images);

        foreach ($ad->moderations()->where('moderation_status_id', 1)->get() as $moderation) {
            if (array_key_exists('preview', $moderation->data)) array_push($files, $moderation->data['preview']);
            if (array_key_exists('images', $moderation->data)) $files = array_merge($files, $moderation->data['images']);
        }

        Storage::disk('public')->delete($files);

        $ad->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);

        $ad->delete();

        return redirect()->route('company', ['user' => $user->slug])->withErrors(['success' => __('The ad has been removed')]);
    }
}
