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
        $source = RatingSource::from($request->source);
        $externalId = $request->id;

        $mapping = ExternalSourcesMapping::where('rating_source_id', $source->value)
            ->where('external_id', $externalId)
            ->first();

        if (!$mapping) return response()->json(['success' => false], 404);

        ExternalRating::create([
            'mapping_id'    => $mapping->id,
            'rating'        => $request->rating,
            'reviews_count' => $request->reviews_count,
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
