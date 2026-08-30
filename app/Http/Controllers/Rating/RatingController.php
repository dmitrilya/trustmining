<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class RatingController extends Controller
{
    public function index(): View
    {
        return view('rating.index', Cache::get('home_page_data'));
    }
}
