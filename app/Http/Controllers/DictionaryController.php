<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
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
        $definition = __("dictionary.$dictionaryCategory->name.terms.$dictionaryTerm->name.definition");
        preg_match_all(
            '/data-term=["\']([^"\']+)["\']/',
            $definition,
            $matches
        );

        $termKeys = array_unique($matches[1]);

        $terms = [];

        foreach ($termKeys as $key) {
            [$category, $term] = explode('/', $key, 2);

            $data = __("dictionary.$category.terms.$term");

            if (!$data) continue;

            $terms[$key] = [
                'name' => $data['name'],
                'caption' => $data['caption'],
            ];
        }

        return view('wiki.dictionary.term', [
            'data' => Cache::get('home_page_data'),
            'category' => $dictionaryCategory,
            'term' => $dictionaryTerm,
            'terms' => $terms
        ]);
    }
}
