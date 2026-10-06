<?php

namespace App\Http\Controllers\Wiki;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

use App\Models\Dictionary\DictionaryCategory;
use App\Models\Dictionary\DictionaryTerm;

class DictionaryController extends Controller
{
    public function index(): View
    {
        $categories = DictionaryCategory::with(['dictionaryTerms' => fn($q) => $q->withCount('views')->orderByDesc('views_count')])->get();

        return view('wiki.dictionary.index', [
            'categories' => $categories,
            'data' => Cache::get('home_page_data'),
        ]);
    }

    public function category(DictionaryCategory $dictionaryCategory): View
    {
        $dictionaryCategory = $dictionaryCategory->load(['dictionaryTerms' => fn($q) => $q->withCount('views')->orderByDesc('views_count')]);

        return view('wiki.dictionary.category', [
            'category' => $dictionaryCategory,
            'data' => Cache::get('home_page_data'),
        ]);
    }

    public function term(DictionaryCategory $dictionaryCategory, DictionaryTerm $dictionaryTerm): View
    {
        return view('wiki.dictionary.term', [
            'data' => Cache::get('home_page_data'),
            'category' => $dictionaryCategory,
            'term' => $dictionaryTerm,
        ]);
    }

    public function termGet(DictionaryCategory $dictionaryCategory, DictionaryTerm $dictionaryTerm): JsonResponse
    {
        return response()->json([
            'name' => __("dictionary.$dictionaryCategory->name.terms.$dictionaryTerm->name.name"),
            'caption' => __("dictionary.$dictionaryCategory->name.terms.$dictionaryTerm->name.caption")
        ], 200);
    }
}
