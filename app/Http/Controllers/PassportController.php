<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePassportRequest;

use App\Http\Traits\FileTrait;

use App\Models\Moderation;
use App\Models\Passport;

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

        Moderation::create([
            'moderationable_type' => 'App\Models\Passport',
            'moderationable_id' => $passport->id,
            'data' => $passport->attributesToArray()
        ]);

        return redirect()->route('profile');
    }
}
