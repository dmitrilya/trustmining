<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use Illuminate\Http\Request;

use App\Http\Traits\FileTrait;
use App\Http\Traits\DaData;

use App\Models\Moderation;
use App\Models\Office;

class OfficeController extends Controller
{
    use FileTrait, DaData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('office.index', ['offices' => Office::where('moderation', false)->with('user:id,url_name')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();

        if ($user->tariff && $user->offices()->count() >= $user->tariff->max_offices || !$user->tariff && $user->offices()->count() >= 1)
            return back()->withErrors(['forbidden' => __('Not available with current plan.')]);

        return view('office.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreOfficeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeRequest $request)
    {
        $user = $request->user();

        if ($user->tariff && $user->offices()->count() >= $user->tariff->max_offices || !$user->tariff && $user->offices()->count() >= 1)
            return back()->withErrors(['forbidden' => __('Not available with current plan.')]);

        $suggestions = $this->dadataSearchAddress($request->address);

        if (!count($suggestions)) return back()->withErrors(['forbidden' => __('Please check the correctness of the specified address')]);

        $address = $suggestions[0]['value'];
        $city = $suggestions[0]['data']['city'];

        $office = Office::create([
            'user_id' => $user->id,
            'address' => $address,
            'city' => $city,
            'video' => $request->video,
            'images' => [],
            'peculiarities' => $request->peculiarities ? $request->peculiarities : [],
        ]);

        $office->images = $this->saveFiles($request->file('images'), 'offices', 'photo', $office->id);
        $office->save();

        Moderation::create([
            'moderationable_type' => 'App\Models\Office',
            'moderationable_id' => $office->id,
            'data' => $office->attributesToArray()
        ]);

        return redirect()->route('profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        if ($office->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        return view('office.edit', ['office' => $office]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfficeRequest
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $user = $request->user();

        if ($office->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $data = [];
        $p = $request->peculiarities ? $request->peculiarities : [];

        if ($request->video != $office->video) $data['video'] = $request->video;
        if (count(array_diff($office->peculiarities, $p)) || count(array_diff($p, $office->peculiarities))) $data['peculiarities'] = $p;

        if ($request->images)
            $data['images'] = $this->saveFiles($request->file('images'), 'offices', 'photo', $office->id);

        if (!empty($data))
            Moderation::create([
                'moderationable_type' => 'App\Models\Office',
                'moderationable_id' => $office->id,
                'data' => $data
            ]);

        return redirect()->route('company.office', ['user' => $user->url_name, 'office' => $office->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }
}
