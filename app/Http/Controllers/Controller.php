<?php

namespace App\Http\Controllers;

use App\Http\Traits\DaData;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\Morph\Like;
use App\Models\Morph\Track;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, DaData;

    public function like(Request $request)
    {
        $modelClass = Relation::getMorphedModel($request->likeableType);
        if (!$modelClass || !($modelClass::find($request->likeableId)))
            return response()->json(['success' => false, 'message' => __('Not available')]);

        $user = $request->user();

        if ($like = $user->likes()->where('likeable_type', $request->likeableType)->where('likeable_id', $request->likeableId)->first())
            $like->delete();
        else Like::create([
            'likeable_type' => $request->likeableType,
            'likeable_id' => $request->likeableId,
            'user_id' => $user->id
        ]);

        return response()->json(['success' => true], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        $modelClass = Relation::getMorphedModel($request->trackable_type);
        if (!$modelClass || !($modelClass::find($request->trackable_id)))
            return response()->json(['success' => false, 'message' => __('Not available')]);

        $user = $request->user();

        // if (!$user || !$user->tariff) return response()->json(['success' => false, 'message' => __('This feature is only available with a subscription')]);

        if ($track = $user->tracks()->where('trackable_type', $request->trackable_type)->where('trackable_id', $request->trackable_id)->first()) {
            $track->delete();
            $tracking = false;
            $message = 'You have unsubscribed from notifications.';
        } else {
            Track::create([
                'trackable_type' => $request->trackable_type,
                'trackable_id' => $request->trackable_id,
                'user_id' => $user->id
            ]);
            $tracking = true;
            $message = 'You have successfully subscribed to price change notifications.';
        }

        return response()->json([
            'success' => true,
            'tracking' => $tracking,
            'message' => __($message)
        ]);
    }
}
