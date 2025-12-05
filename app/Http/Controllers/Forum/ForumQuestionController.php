<?php

namespace App\Http\Controllers\Forum;

use App\Http\Requests\Forum\StoreForumQuestionRequest;

use App\Models\Forum\ForumQuestion;

class ForumQuestionController extends ForumController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum.question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Forum\StoreForumQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForumQuestionRequest $request)
    {
        $this->questionService->store($request->user(), $request->theme, $request->text, $request->file('images'));

        return redirect()->route('forum');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forum\ForumQuestion  $question
     * @return \Illuminate\Http\Response
     */
    public function show(ForumQuestion $question)
    {
        $this->addView(request(), $question);

        $question->load(['forumAnswers' => fn($q) => $q->withCount('likes'), 'forumAnswers.forumComments']);

        return view('forum.question.show', compact($question));
    }
}
