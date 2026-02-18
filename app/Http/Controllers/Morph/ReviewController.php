<?php

namespace App\Http\Controllers\Morph;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreReviewRequest;

use App\Jobs\CheckReview;

use App\Http\Traits\FileTrait;

use App\Models\Morph\Review;

class ReviewController extends Controller
{
    use FileTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewRequest $request)
    {
        $review = Review::create([
            'user_id' => $request->user()->id,
            'reviewable_id' => $request->reviewable_id,
            'reviewable_type' => $request->reviewable_type,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        if ($request->file('image')) $review->image = $this->saveFile($request->file('image'), 'reviews', 'image', $review->id, 'private/');
        if ($request->file('document')) $review->document = $this->saveFile($request->file('document'), 'reviews', 'doc', $review->id, 'private/');

        $review->save();

        $review->moderation()->create(['data' => $review->attributesToArray()]);

        CheckReview::dispatch($review)->delay(now()->addMinutes(rand(90, 150)));

        return response()->json(['success' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Morph\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if ($review->fake) return back()->withErrors(['forbidden' => __('A review that we have found to be fake can only be edited/deleted through our support service')]);

        $files = [];
        if ($review->image) array_push($files, $review->image);
        if ($review->document) array_push($files, $review->document);

        if (!empty($files)) Storage::disk('private')->delete($files);

        $review->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);

        $review->delete();

        return back()->withErrors(['success' => __('The review has been removed')]);
    }
}
