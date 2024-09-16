<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use Illuminate\Http\Request;

use App\Http\Traits\FileTrait;

use App\Models\Moderation;
use App\Models\Office;

class OfficeController extends Controller
{
    use FileTrait;

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

        $office = Office::create([
            'user_id' => $user->id,
            'address' => $request->address,
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
        if (\Auth::user()->id != $office->user->id) return back();

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

        if ($office->user->id != $user->id) return back();

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
