<?php

namespace App\Http\Controllers\Wiki;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

use App\Models\Database\Algorithm;

class AlgorithmController extends Controller
{
    public function index(): View
    {
        $algorithms = Algorithm::with(['coins'])->withCount('views')->orderByDesc('views_count')->get();

        return view('wiki.algorithms.index', [
            'algorithms' => $algorithms,
            'data' => Cache::get('home_page_data'),
        ]);
    }

    public function show(Algorithm $algorithm): View
    {
        return view('wiki.algorithms.show', [
            'algorithm' => $algorithm,
            'data' => Cache::get('home_page_data'),
        ]);
    }
}
