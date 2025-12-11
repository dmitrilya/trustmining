<?php

namespace App\Http\Controllers\Forum;

use App\Http\Requests\Forum\StoreForumCommentRequest;

class ForumCommentController extends ForumController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Forum\StoreForumCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForumCommentRequest $request)
    {
        $this->commentService->store($request->user(), $request->text, $request->file('images'), $request->forum_answer_id);

        return redirect()->route('forum');
    }
}
