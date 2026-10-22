<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Enums\VotingCategory;

class VotingController extends Controller
{
    public function show(string $categorySlug): View
    {
        $category = VotingCategory::fromSlug($categorySlug);

        if (!$category) abort(404);

        $modelClass = $category->modelClass();
        $candidates = $category->applyFilter($modelClass::query())->inRandomOrder()->get()
            ->map(fn($candidate) => $category->mapCandidate($candidate));

        return view('voting.show', [
            'data' => Cache::get('home_page_data'),
            'category' => $category,
            'candidates' => $candidates
        ]);
    }

    public function vote(Request $request, string $categorySlug): JsonResponse
    {
        $category = VotingCategory::fromSlug($categorySlug);

        if (!$category) return response()->json(['success' => false], 404);

        $voteableType = $request->input('voteable_type');
        $voteableId = $request->input('voteable_id');
        $fingerprint = $request->input('fingerprint');
        if (!$fingerprint || strlen($fingerprint) !== 32) return response()->json(['success' => false], 400);

        $modelClass = Relation::getMorphedModel($voteableType) ?? $voteableType;
        if ($modelClass !== $category->modelClass()) return response()->json(['success' => false], 422);

        $candidate = $modelClass::findOrFail($voteableId);
        if (!$category->validateCandidate($candidate)) return response()->json(['success' => false], 422);

        $yearMonth = (int) now()->format('Ym');
        $ip = $request->ip();

        $fingerprintIpHash = md5($yearMonth . '_' . $category->value . '_' . $ip . '_' . $fingerprint);

        $votesFromThisIp = DB::table('votes')->where('year_month', $yearMonth)
            ->where('category_id', $category->value)->where('ip_address', inet_pton($ip))->count();

        if ($votesFromThisIp >= 5) return response()->json([
            'success' => false,
            'message' => __('The voting limit for your internet connection has been exceeded')
        ], 429);

        try {
            DB::table('votes')->insert([
                'category_id'         => $category->value,
                'voteable_type'       => $voteableType,
                'voteable_id'         => $voteableId,
                'year_month'          => $yearMonth,
                'ip_address'          => inet_pton($ip),
                'fingerprint'         => $fingerprint,
                'fingerprint_ip_hash' => $fingerprintIpHash,
                'created_at'          => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => __('Your vote has been successfully counted')
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'reason' => 'already participated',
                    'message' => __('You have already participated in this vote')
                ], 422);
            }

            throw $e;
        }
    }
}
