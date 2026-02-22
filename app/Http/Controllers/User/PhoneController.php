<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Traits\ViewTrait;

use App\Models\User\Phone;
use App\Models\User\User;

class PhoneController extends Controller
{
    use ViewTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->tariff || !$user->tariff->can_have_phone)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $pattern = '/[^0-9]/';
        Phone::create(['user_id' => $request->user()->id, 'number' => preg_replace($pattern, "", $request->number)]);

        return back()->withErrors(['success' => __('The phone number has been added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if (!$user->tariff || !$user->tariff->can_have_phone) return response()->json(['success' => false, 'number' => __('Not available')]);

        $phone = $user->phones()->first();

        $this->addView(request(), $phone, $request->ad_id);

        return response()->json(['success' => true, 'number' => $phone->number]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\User\Phone  $track
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phone $phone)
    {
        $user = $request->user();

        if (!$user->tariff || !$user->tariff->can_have_phone)
            return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $pattern = '/[^0-9]/';
        $phone->number = preg_replace($pattern, "", $request->number);
        $phone->save();

        return back()->withErrors(['success' => __('The phone number has been updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phone $phone)
    {
        $phone->destroyed = true;
        $phone->save();

        return back()->withErrors(['success' => __('The phone number has been destroyed')]);
    }
}
