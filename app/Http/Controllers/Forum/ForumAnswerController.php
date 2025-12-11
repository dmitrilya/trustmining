<?php

namespace App\Http\Controllers\Forum;

use App\Http\Requests\Forum\StoreForumAnswerRequest;

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
}
