<?php

namespace App\Http\Controllers\Ad;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Blade;
use Mews\Purifier\Facades\Purifier;

use App\Http\Requests\StoreHostingRequest;
use App\Http\Requests\UpdateHostingRequest;
use Illuminate\Http\Request;

use App\Http\Traits\HostingTrait;
use App\Http\Traits\FileTrait;

use App\Models\Ad\Hosting;
use App\Models\City;

class HostingController extends Controller
{
    use HostingTrait, FileTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hostings = $this->getHostings($request)->orderByDesc('ordering_id');

        if ($request->ajax()) return response()->json([
            'html' => view('hosting.components.list', ['hostings' => $hostings->paginate($request->count), 'auth' => $request->user()])->render(),
            'hasMore' => $hostings->hasMorePages()
        ]);

        return view('hosting.index', ['hostings' => $hostings->paginate(15)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHostingsCarousel(Request $request)
    {
        $hostings = $this->getHostings($request)->orderByDesc('ordering_id')->paginate(4);

        if ($request->ajax()) return response()->json([
            'html' => Blade::render(
                '<x-carousel.list :items="$hostings" blade="hosting.components.card" model="hosting" sm="true />',
                [
                    'items' => $hostings,
                ]
            ),
            'hasMore' => $hostings->hasMorePages()
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

        if (!$user->tariff || $user->hostings()->count() >= $user->tariff->max_hostings)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        return view('hosting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHostingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHostingRequest $request)
    {
        $user = $request->user();

        if (!$user->tariff || $user->hostings()->count() >= $user->tariff->max_hostings)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $suggestions = $this->dadataSearchAddress($request->address);

        if (!count($suggestions) || !$suggestions[0]['data']['postal_code']) return back()->withErrors(['forbidden' => __('Please check the correctness of the specified address')]);

        $currentLocale = app()->getLocale();
        $alternativeLocale = $currentLocale == 'ru' ? 'en' : 'ru';

        $currentCityName = $suggestions[0]['data']['city'];

        $city = City::where("name->{$currentLocale}", $currentCityName)->first();

        if (!$city) {
            $alternativeSuggestions = $this->dadataSearchAddress($request->address, $alternativeLocale);
            $alternativeCityName = $alternativeSuggestions[0]['data']['city'] ?? $currentCityName;

            $city = City::create([
                'name' => [$currentLocale => $currentCityName, $alternativeLocale => $alternativeCityName],
                'name_where' => []
            ]);
        }

        $firstHosting = Hosting::orderByDesc('ordering_id')->first();
        $hosting = Hosting::create([
            'ordering_id' => $firstHosting ? $firstHosting->ordering_id + 1 : 1,
            'user_id' => $user->id,
            'description' => Purifier::clean(htmlspecialchars_decode($request->description), 'description'),
            'address' => $suggestions[0]['value'],
            'city_id' => $city->id,
            'video' => $request->video,
            'images' => [],
            'contract_deficiencies' => [],
            'tariffs' => $request->tariffs ?? [],
            'peculiarities' => $request->peculiarities ?? [],
            'conditions' => $request->conditions ?? [],
            'expenses' => $request->expenses ?? [],
        ]);

        $time = time();
        $hosting->images = $this->saveFiles($request->file('images'), 'hostings', 'photo', $hosting->id, $time, [608, null], $user->name);
        $this->saveFile($request->file('images')[0], 'hostings', 'photo', $hosting->id . '_0', $time, [400, 300], $user->name);
        $this->saveFile($request->file('images')[0], 'hostings', 'photo', $hosting->id . '_0', $time, [224, 168], $user->name);
        if ($request->contract) $hosting->contract = $this->saveContract($request->file('contract'), 'hostings', $hosting);
        if ($request->territory) $hosting->territory = $this->saveFile($request->file('territory'), 'hostings', 'territory', $hosting->id, $time);
        if ($request->energy_supply) $hosting->energy_supply = $this->saveFile($request->file('energy_supply'), 'hostings', 'energy_supply', $hosting->id, $time);

        $hosting->save();

        $hosting->moderations()->create(['data' => $hosting->attributesToArray()]);

        return redirect()->route('company.hosting', ['user' => $user->slug, 'hosting' => strtolower($city->name['en']) . '-' . $hosting->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad\Hosting  $hosting
     * @return \Illuminate\Http\Response
     */
    public function edit(Hosting $hosting)
    {
        $user = Auth::user();

        if ($hosting->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        return view('hosting.edit', compact('hosting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHostingRequest  $request
     * @param  \App\Models\Ad\Hosting  $hosting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHostingRequest $request, Hosting $hosting)
    {
        $user = $request->user();

        if ($hosting->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $data = [];
        $t = $request->tariffs ?? [];
        $p = $request->peculiarities ?? [];
        $c = $request->conditions ?? [];
        $e = $request->expenses ?? [];

        if ($request->description != $hosting->description) $data['description'] = Purifier::clean(htmlspecialchars_decode($request->description), 'description');
        if ($request->video != $hosting->video) $data['video'] = $request->video;

        $currentTariffs = collect($hosting->tariffs);
        $newTariffs = collect($t);

        if ($currentTariffs->count() !== $newTariffs->count() || $newTariffs->diff($currentTariffs)->isNotEmpty()) $data['tariffs'] = $t;

        if (count(array_diff($hosting->peculiarities, $p)) || count(array_diff($p, $hosting->peculiarities))) $data['peculiarities'] = $p;
        if (count(array_diff($hosting->conditions, $c)) || count(array_diff($c, $hosting->conditions))) $data['conditions'] = $c;
        if (count(array_diff($hosting->expenses, $e)) || count(array_diff($e, $hosting->expenses))) $data['expenses'] = $e;

        $time = time();

        if ($request->images) {
            $data['images'] = $this->saveFiles($request->file('images'), 'hostings', 'photo', $hosting->id, $time, [608, null], $user->name);
            $this->saveFile($request->file('images')[0], 'hostings', 'photo', $hosting->id . '_0', $time, [400, 300], $user->name);
            $this->saveFile($request->file('images')[0], 'hostings', 'photo', $hosting->id . '_0', $time, [224, 168], $user->name);
        }

        if ($request->contract) $data['contract'] = $this->saveContract($request->file('contract'), 'hostings', $hosting);
        if ($request->territory) $data['territory'] = $this->saveFile($request->file('territory'), 'hostings', 'territory', $hosting->id, $time);
        if ($request->energy_supply) $data['energy_supply'] = $this->saveFile($request->file('energy_supply'), 'hostings', 'energy_supply', $hosting->id, $time);

        if (!empty($data)) $hosting->moderations()->create(['data' => $data]);

        return redirect()->route('company.hosting', ['user' => $user->slug, 'hosting' => strtolower($hosting->cityRelation->name['en']) . '-' . $hosting->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad\Hosting  $hosting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hosting $hosting)
    {
        $files = array_merge($hosting->images, [$hosting->contract, $hosting->territory, $hosting->energy_supply]);

        foreach ($hosting->moderations()->where('moderation_status_id', 1)->get() as $moderation) {
            if (array_key_exists('images', $moderation->data)) $files = array_merge($files, $moderation->data['images']);
            if (array_key_exists('contract', $moderation->data)) array_push($files, $moderation->data['contract']);
            if (array_key_exists('territory', $moderation->data)) array_push($files, $moderation->data['territory']);
            if (array_key_exists('energy_supply', $moderation->data)) array_push($files, $moderation->data['energy_supply']);
        }

        Storage::disk('public')->delete($files);

        $hosting->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);
        $hosting->delete();

        return redirect()->route('profile');
    }
}
