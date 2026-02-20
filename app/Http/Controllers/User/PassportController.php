<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\StorePassportRequest;

use App\Http\Traits\FileTrait;

use App\Models\User\Passport;

class PassportController extends Controller
{
    use FileTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePassportRequest $request)
    {
        $user = $request->user();

        if ($user->passport) return redirect()->route('profile');

        $passport = Passport::create([
            'user_id' => $user->id,
            'images' => []
        ]);

        $passport->images = $this->saveFiles($request->file('images'), 'passports', 'image', $passport->id, 'private/');
        $passport->save();

        $passport->moderations()->create(['data' => $passport->attributesToArray()]);

        return redirect()->route('profile');
    }
}
