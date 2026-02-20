<?php

namespace App\Http\Controllers\Ad;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreHostingRequest;
use App\Http\Requests\UpdateHostingRequest;
use Illuminate\Http\Request;

use App\Http\Traits\HostingTrait;
use App\Http\Traits\FileTrait;

use App\Models\Ad\Hosting;

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
        return view('hosting.index', ['hostings' => $this->getHostings($request)->orderByDesc('ordering_id')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();

        if ($user->hosting) return back()->withErrors(['forbidden' => __('Hosting already exists.')]);

        if (!$user->tariff || !$user->tariff->can_have_hosting)
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

        if ($user->hosting) return redirect()->route('profile')->withErrors(['forbidden' => __('Hosting already exists.')]);

        if (!$user->tariff || !$user->tariff->can_have_hosting)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $firstHosting = Hosting::orderByDesc('ordering_id')->first();
        $hosting = Hosting::create([
            'ordering_id' => $firstHosting ? $firstHosting->ordering_id + 1 : 1,
            'user_id' => $user->id,
            'description' => $request->description,
            'address' => $request->address ? $request->address : 'Not specified',
            'video' => $request->video,
            'price' => $request->price,
            'images' => [],
            'contract' => '',
            'contract_deficiencies' => [],
            'peculiarities' => $request->peculiarities ? $request->peculiarities : [],
            'conditions' => $request->conditions ? $request->conditions : [],
            'expenses' => $request->expenses ? $request->expenses : [],
        ]);

        $hosting->images = $this->saveFiles($request->file('images'), 'hostings', 'photo', $hosting->id);
        $hosting->contract = $this->saveContract($request->file('contract'), 'hostings', $hosting);
        if ($request->territory) $hosting->territory = $this->saveFile($request->file('territory'), 'hostings', 'territory', $hosting->id);
        if ($request->energy_supply) $hosting->energy_supply = $this->saveFile($request->file('energy_supply'), 'hostings', 'energy_supply', $hosting->id);

        $hosting->save();

        $hosting->moderations()->create(['data' => $hosting->attributesToArray()]);

        return redirect()->route('company.hosting', ['user' => $user->url_name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad\Hosting  $hosting
     * @return \Illuminate\Http\Response
     */
    public function edit(Hosting $hosting)
    {
        $user = \Auth::user();

        if ($hosting->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        if (!$user->tariff || !$user->tariff->can_have_hosting)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        return view('hosting.edit', compact('hosting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateHostingRequest  $request
     * @param  \App\Models\Ad\Hosting  $hosting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHostingRequest $request, Hosting $hosting)
    {
        $user = $request->user();

        if ($hosting->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        if (!$user->tariff || !$user->tariff->can_have_hosting)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $data = [];
        $p = $request->peculiarities ? $request->peculiarities : [];
        $c = $request->conditions ? $request->conditions : [];
        $e = $request->expenses ? $request->expenses : [];

        if ($request->description != $hosting->description) $data['description'] = $request->description;
        if ($request->address != $hosting->address) $data['address'] = $request->address ? $request->address : 'Not specified';
        if ($request->video != $hosting->video) $data['video'] = $request->video;
        if ($request->price != $hosting->price) $data['price'] = $request->price;
        if (count(array_diff($hosting->peculiarities, $p)) || count(array_diff($p, $hosting->peculiarities))) $data['peculiarities'] = $p;
        if (count(array_diff($hosting->conditions, $c)) || count(array_diff($c, $hosting->conditions))) $data['conditions'] = $c;
        if (count(array_diff($hosting->expenses, $e)) || count(array_diff($e, $hosting->expenses))) $data['expenses'] = $e;

        if ($request->images)
            $data['images'] = $this->saveFiles($request->file('images'), 'hostings', 'photo', $hosting->id);

        if ($request->contract) $data['contract'] = $this->saveContract($request->file('contract'), 'hostings', $hosting);
        if ($request->territory) $data['territory'] = $this->saveFile($request->file('territory'), 'hostings', 'territory', $hosting->id);
        if ($request->energy_supply) $data['energy_supply'] = $this->saveFile($request->file('energy_supply'), 'hostings', 'energy_supply', $hosting->id);

        if (!empty($data))
            $hosting->moderations()->create(['data' => $data]);

        return redirect()->route('company.hosting', ['user' => $user->url_name]);
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
