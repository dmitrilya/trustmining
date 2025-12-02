<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;

class ForumAnswerController extends ForumController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Forum\StoreForumQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForumQuestionRequest $request)
    {
        $question = $request->user()->forumQuestions()->create([
            'theme' => $request->theme,
            'text' => $request->text,
            'images' => []
        ]);

        $question->images = $this->saveFiles($request->file('images'), 'forum', 'question', $question->id);
        $question->save();

        return back();
    }
}
