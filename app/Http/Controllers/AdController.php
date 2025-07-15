<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;
use Illuminate\Http\Request;

use App\Http\Traits\NotificationTrait;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ViewTrait;
use App\Http\Traits\AdTrait;

use App\Models\Ad;
use App\Models\Coin;
use App\Models\Office;
use App\Models\AsicModel;
use App\Models\Moderation;

class AdController extends Controller
{
    use NotificationTrait, FileTrait, ViewTrait, AdTrait;

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request;
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('ad.index', ['ads' => $this->getAds($request)->orderByDesc('ordering_id')->paginate(30)]);
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
            'offices' => $user->offices()->where('moderation', false)->select(['id', 'address'])->get(),
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

        if (!$office || $office->moderation) return back()->withErrors(['forbidden' => __('Unavailable office.')]);

        $firstAd = Ad::orderByDesc('ordering_id')->first();
        $ad = Ad::create([
            'ordering_id' => $firstAd ? $firstAd->ordering_id + 1 : 1,
            'user_id' => $user->id,
            'ad_category_id' => $request->ad_category_id,
            'asic_version_id' => $request->asic_version_id,
            'office_id' => $request->office_id,
            'description' => '',
            'new' => $request->filled('new'),
            'warranty' => $request->filled('new') ? null : $request->warranty,
            'in_stock' => $request->filled('in_stock'),
            'waiting' => $request->filled('in_stock') ? null : $request->waiting,
            'price' => $request->price,
            'images' => [],
            'preview' => '',
            'coin_id' => $request->coin_id,
        ]);

        $ad->images = $this->saveFiles($request->file('images'), 'ads', 'photo', $ad->id);
        $ad->preview = $this->saveFile($request->file('preview'), 'ads', 'preview', $ad->id);

        $ad->save();

        Moderation::create([
            'moderationable_type' => 'App\Models\Ad',
            'moderationable_id' => $ad->id,
            'data' => $ad->attributesToArray()
        ]);

        return redirect()->route('company', ['user' => $user->url_name]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
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
     * @param  \App\Models\Ad  $ad
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdRequest  $request
     * @param  \App\Models\Ad  $ad
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

        if (!$ad->new) {
            if ($request->warranty != $ad->warranty) $data['warranty'] = $request->warranty;

            if ($request->images)
                $data['images'] = $this->saveFiles($request->file('images'), 'ads', 'photo', $ad->id);
        }

        if (!$ad->in_stock && $request->waiting != $ad->waiting) $data['waiting'] = $request->waiting;

        if ($request->price != $ad->price || $request->coin_id != $ad->coin_id) {
            $data['price'] = $request->price;
            $data['coin_id'] = $request->coin_id;
        }

        if ($request->preview)
            $data['preview'] = $this->saveFile($request->file('preview'), 'ads', 'preview', $ad->id);

        if (!empty($data)) {
            $moderation = Moderation::create([
                'moderationable_type' => 'App\Models\Ad',
                'moderationable_id' => $ad->id,
                'data' => $data
            ]);

            if (!$request->preview && ($ad->new || !$request->images)) {
                $moderation->moderation_status_id = 2;
                $moderation->user_id = 10000000;
                $moderation->save();

                if ($request->price != $ad->price || $request->coin_id != $ad->coin_id) $this->notify(
                    'Price change',
                    $ad->trackingUsers()->select(['users.id', 'users.tg_id'])->get(),
                    'App\Models\Ad',
                    $ad
                );

                $ad->update($data);
            }
        }

        return redirect()->route('ads.show', ['ad' => $ad->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request;
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function toggleHidden(Request $request, Ad $ad)
    {
        $user = $request->user();

        if ($ad->hidden && ($user->tariff && $user->ads()->where('hidden', false)->count() >= $user->tariff->max_ads || !$user->tariff && $user->ads()->where('hidden', false)->count() >= 2))
            return response()->json(['success' => false, 'message' => __('Not available with current plan')]);

        $ad->hidden = !$ad->hidden;
        $ad->save();

        return response()->json(['success' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request;
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request, Ad $ad)
    {
        $user = $request->user();

        if (!$user || !$user->tariff) return response()->json(['success' => false, 'message' => __('This feature is only available with a subscription')]);

        if ($ad->trackingUsers()->where('users.id', $user->id)->exists()) {
            $ad->trackingUsers()->detach($user->id);
            $tracking = false;
            $message = 'You have unsubscribed from notifications.';
        } else {
            $ad->trackingUsers()->attach($user->id);
            $tracking = true;
            $message = 'You have successfully subscribed to price change notifications.';
        }

        return response()->json(['success' => true, 'tracking' => $tracking, 'message' => __($message)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
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
