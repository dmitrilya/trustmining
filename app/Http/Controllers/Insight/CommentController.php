<?php

namespace App\Http\Controllers\Insight;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Insight\Comment;

class CommentController extends Controller
{
    /**
     * Comment reaction
     *
     * @param Request  $request
     * @param Comment  $comment
     * @param string  $type
     * @return Response
     */
    public function reaction(Request $request, Comment $comment, string $type)
    {
        $lastReaction = $comment->reactions()->where('user_id', $request->user()->id)->first();
        if ($lastReaction) $lastReaction->delete();
        
        if (!$lastReaction || $lastReaction->type != $type) $comment->reactions()->create(['user_id' => $request->user()->id, 'type' => $type]);

        return response()->json(['success' => true]);
    }
}