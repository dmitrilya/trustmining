<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function inp(Request $request): void
    {
        Log::channel('analytics')->info("[⚠️ POOR INP]\nvalue={$request->value}\nevent={$request->event}\nurl={$request->url}\ntarget={$request->target}");
    }
}
