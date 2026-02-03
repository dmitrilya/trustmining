<?php

namespace App\Http\Controllers\Forum;

use App\Http\Requests\Forum\StoreForumCommentRequest;
use App\Http\Requests\Forum\UpdateForumCommentRequest;

use App\Models\Forum\ForumComment;

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
        $this->commentService->store($request->user(), $request->text, $request->file('images'), $request->file('files'), $request->forum_answer_id);

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateForumCommentRequest  $request
     * @param  \App\Models\Forum\ForumComment  $forumComment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForumCommentRequest $request, ForumComment $forumComment)
    {
        if ($forumComment->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $this->commentService->update($forumComment, $request->text, $request->file('images'), $request->file('files'));

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Forum\ForumComment  $forumComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumComment $forumComment)
    {
        $this->commentService->destroy($forumComment);

        return back();
    }
}
