<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

use App\Enums\RatingSource;
use App\Models\ExternalRating;
use App\Models\ExternalSourcesMapping;

class ExternalRatingController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'source'        => ['required', new Enum(RatingSource::class)],
            'id'            => ['required', 'string'],
            'rating'        => ['required', 'float'],
            'reviews_count' => ['required', 'integer'],
        ]);

        $source = RatingSource::from($validated['source']);
        $externalId = $validated['id'];

        $mapping = ExternalSourcesMapping::where('rating_source_id', $source->value)
            ->where('external_id', $externalId)
            ->first();

        if (!$mapping) return response()->json(['success' => false], 404);

        ExternalRating::create([
            'mapping_id'    => $mapping->id,
            'rating'        => $validated['rating'],
            'reviews_count' => $validated['reviews_count'],
        ]);

        $targetEntity = $mapping->ratable;
        if ($targetEntity && method_exists($targetEntity, 'recalculateCachedRatings'))
            $targetEntity->recalculateCachedRatings();

        return response()->json([
            'success' => true,
        ]);
    }

    public function getAllLinks()
    {
        $mappings = \App\Models\ExternalSourcesMapping::all();

        $links = [];

        foreach ($mappings as $mapping) {
            $sourceEnum = $mapping->rating_source_id;
            $href = $sourceEnum->href($mapping->external_id);

            if ($href) $links[] = $href;
        }

        return response()->json([
            'links' => $links
        ]);
    }
}
