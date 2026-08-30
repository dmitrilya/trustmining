<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\User\User;

class CompanyRatingController extends Controller
{
    public function show(): View
    {
        return view('rating.companies.index', ['users' => User::select(['id', 'name', 'slug', 'tf', 'tariff_id'])->orderByDesc('tf')->limit(10)
            ->with(['company:user_id,logo,card,moderation', 'moderatedReviews', 'passport:moderation'])->get()]);
    }
}
