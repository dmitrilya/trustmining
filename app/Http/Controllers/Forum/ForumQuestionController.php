<?php

namespace App\Http\Controllers\Forum;

use App\Http\Requests\Forum\StoreForumQuestionRequest;
use App\Http\Traits\ViewTrait;
use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumSubcategory;
use App\Models\Forum\ForumQuestion;

class ForumQuestionController extends ForumController
{
    use ViewTrait;

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
     * @param  \App\Models\Forum\ForumCategory  $forumCategory
     * @param  \App\Models\Forum\ForumSubcategory  $forumSubcategory
     * @param  \App\Models\Forum\ForumQuestion  $forumQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(ForumCategory $forumCategory, ForumSubcategory $forumSubcategory, ForumQuestion $forumQuestion)
    {
        $this->addView(request(), $forumQuestion);

        $forumQuestion->load([
            'moderatedForumAnswers' => fn($q) => $q->withCount('likes')->orderByDesc('likes_count')->with([
                'likes',
                'user' => fn($q2) => $q2->select(['id', 'name'])->withCount('moderatedForumAnswers'),
                'moderatedForumComments',
                'moderatedForumComments.user' => fn($q2) => $q2->select(['id', 'name'])->withCount('moderatedForumAnswers'),
            ]),
            'user' => fn($q) => $q->select(['id', 'name'])->withCount('moderatedForumAnswers'),
        ])->loadCount('views');

        $similarQuestions = ForumQuestion::where('moderation', false)->select('id')->selectRaw('JSON_LENGTH(keywords) AS total_keywords')
            ->selectRaw("(SELECT COUNT(*) FROM JSON_TABLE(? , '$[*]' COLUMNS (kw VARCHAR(255) PATH '$')) AS s
            WHERE JSON_CONTAINS(forum_questions.keywords, JSON_QUOTE(s.kw))
        ) AS matches", [json_encode($forumQuestion->keywords)])->havingRaw('matches / total_keywords >= ?', [0.75])
            ->orderByDesc('matches')->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])->limit(5)->get();

        $newQuestions = ForumQuestion::where('moderation', false)->select(['id', 'forum_subcategory_id', 'theme'])
            ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
            ->latest()->limit(5)->get();

        return view('forum.question.show', [
            'category' => $forumCategory,
            'subcategory' => $forumSubcategory,
            'question' => $forumQuestion,
            'similarQuestions' => $similarQuestions,
            'newQuestions' => $newQuestions,
            'user' => request()->user()
        ]);
    }
}
