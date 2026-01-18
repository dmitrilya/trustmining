<?php

namespace App\Http\Controllers\Forum;

use App\Http\Requests\Forum\StoreForumAnswerRequest;
use App\Http\Requests\Forum\UpdateForumAnswerRequest;

use App\Models\Forum\ForumAnswer;

class ForumAnswerController extends ForumController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Forum\StoreForumAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForumAnswerRequest $request)
    {
        $this->answerService->store($request->user(), $request->text, $request->file('images'), $request->forum_question_id);

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateForumAnswerRequest  $request
     * @param  \App\Models\Forum\ForumAnswer  $forumAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForumAnswerRequest $request, ForumAnswer $forumAnswer)
    {
        if ($forumAnswer->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $this->answerService->update($forumAnswer, $request->text, $request->file('images'));

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Forum\ForumAnswer  $forumAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumAnswer $forumAnswer)
    {
        $this->answerService->destroy($forumAnswer);

        return back();
    }
}
