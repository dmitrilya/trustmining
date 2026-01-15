<?php

namespace App\Http\Controllers\Ad;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;
use Illuminate\Http\Request;

use App\Http\Traits\NotificationTrait;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ViewTrait;
use App\Http\Traits\AdTrait;

use App\Models\Ad\Ad;
use App\Models\Ad\AdCategory;
use App\Models\Database\Coin;
use App\Models\User\Office;
use App\Models\Database\AsicModel;
use App\Models\Morph\Moderation;

class AdController extends Controller
{
    use NotificationTrait, FileTrait, ViewTrait, AdTrait;

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request  $request;
     * @param  \App\Models\Ad\AdCategory  $adCategory;
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AdCategory $adCategory)
    {
        return view('ad.index', [
            'ads' => $this->getAds($request, $adCategory)->orderByDesc('ordering_id')->paginate(30)->withQueryString(),
            'adCategory' => $adCategory
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();

        if ($user->tariff && $user->ads()->count() >= $user->tariff->max_ads || !$user->tariff && $user->ads()->count() >= 2)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        return view('ad.create', [
            'models' => AsicModel::select(['id', 'name'])->with('asicVersions:id,asic_model_id,hashrate')->get(),
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

        if ($user->tariff && $user->ads()->count() >= $user->tariff->max_ads || !$user->tariff && $user->ads()->count() >= 2)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $office = Office::find($request->office_id);

        if (!$office) return back()->withErrors(['forbidden' => __('Unavailable office.')]);

        $firstAd = Ad::orderByDesc('ordering_id')->first();
        $ad = Ad::create([
            'ordering_id' => $firstAd ? $firstAd->ordering_id + 1 : 1,
            'user_id' => $user->id,
            'ad_category_id' => $request->ad_category_id,
            'asic_version_id' => $request->asic_version_id,
            'office_id' => $request->office_id,
            'description' => $request->description ?? '',
            'props' => json_decode($request->props),
            'price' => $request->price,
            'images' => [],
            'preview' => '',
            'coin_id' => $request->coin_id,
        ]);

        $ad->images = $this->saveFiles($request->file('images'), 'ads', 'photo', $ad->id);
        $ad->preview = $this->saveFile($request->file('preview'), 'ads', 'preview', $ad->id);

        $ad->save();

        Moderation::create([
            'moderationable_type' => 'App\Models\Ad\Ad',
            'moderationable_id' => $ad->id,
            'data' => $ad->attributesToArray()
        ]);

        return redirect()->route('company', ['user' => $user->url_name]);
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
        $user = \Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $ad->user->id) && ($ad->moderation || $ad->hidden))
            return back()->withErrors(['forbidden' => __('Unavailable ad.')]);

        $this->addView(request(), $ad);

        return view('ad.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        $user = \Auth::user();

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
     * @param  Illuminate\Http\Request;
     * @return \Illuminate\Http\Response
     */
    public function editMass(Request $request)
    {
        return view('ad.edit-mass', [
            'ads' => $request->user()->ads()->where('ad_category_id', 1)->where('moderation', false)->with([
                'office:id,city',
                'coin:id,abbreviation',
                'asicVersion:id,hashrate,measurement,asic_model_id',
                'asicVersion.asicModel:id,name'
            ])->get()->sortBy(['asicVersion.asicModel.name', 'asicVersion.hashrate']),
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

        $data = [];

        if ($request->office_id != $ad->office_id) {
            $office = Office::find($request->office_id);

            if (!$office || $office->moderation) return back()->withErrors(['forbidden' => __('Unavailable office.')]);

            $data['office_id'] = $request->office_id;
        }

        $props = json_decode($request->props, true);
        $propDiffs = array_merge(array_diff_assoc($ad->props, $props), array_diff_assoc($props, $ad->props));
        if (count($propDiffs)) $data['props'] = $props;

        if ($request->description != $ad->description) $data['description'] = $request->description;

        if ($request->images)
            $data['images'] = $this->saveFiles($request->file('images'), 'ads', 'photo', $ad->id);

        if ($request->price != $ad->price || $request->coin_id != $ad->coin_id) {
            $data['price'] = $request->price;
            $data['coin_id'] = $request->coin_id;
        }

        if ($request->preview)
            $data['preview'] = $this->saveFile($request->file('preview'), 'ads', 'preview', $ad->id);

        if (!empty($data)) {
            $moderation = Moderation::create([
                'moderationable_type' => 'App\Models\Ad\Ad',
                'moderationable_id' => $ad->id,
                'data' => $data
            ]);

            if (!$request->preview && !$request->images && !$request->description) {
                $moderation->moderation_status_id = 2;
                $moderation->user_id = 10000000;
                $moderation->save();

                if (isset($data['price'])) $this->notify(
                    'Price change',
                    $ad->trackingUsers()->select(['users.id', 'users.tg_id'])->get(),
                    'App\Models\Ad\Ad',
                    $ad
                );

                $ad->update($data);
            }
        }

        return redirect()->route('ads.show', ['adCategory' => $ad->adCategory->name, 'ad' => $ad->id]);
    }

    /**
     * Update listing of the resource in storage.
     *
     * @param  Illuminate\Http\Request;
     * @return \Illuminate\Http\Response
     */
    public function updateMass(Request $request)
    {
        $changings = collect($request->changings);
        $request->user()->ads()->whereIn('id', $changings->pluck('id'))->get()
            ->each(function ($ad) use ($changings) {
                $change = $changings->where('id', $ad->id)->first();
                if (isset($change['price'])) $ad->price = $change['price'];
                if (isset($change['coin_id'])) $ad->coin_id = $change['coin_id'];
                $ad->save();
            });

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
        $user = \Auth::user();

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

        return redirect()->route('company', ['user' => $user->url_name])->withErrors(['success' => __('The ad has been removed')]);
    }
}
