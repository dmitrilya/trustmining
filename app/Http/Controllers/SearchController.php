<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\SearchService;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request, SearchService $searchService): JsonResponse
    {
        return response()->json([
            'success' => true,
            'suggestions' => $searchService->search(
                trim($request->input('query', ''))
            ),
        ]);
    }
}
