<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Contracts\View\View;
use App\Http\Requests\Forum\StoreForumQuestionRequest;
use App\Http\Requests\Forum\UpdateForumQuestionRequest;
use Illuminate\Http\Request;
use App\Http\Traits\ViewTrait;
use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumSubcategory;
use App\Models\Forum\ForumQuestion;

class ForumQuestionController extends ForumController
{
    use ViewTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myQuestions(Request $request): View
    {
        $questions = $request->user()->forumQuestions()
            ->select(['id', 'forum_subcategory_id', 'theme', 'moderation', 'similar_questions', 'published', 'created_at'])
            ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
            ->withCount('moderatedForumAnswers')->withCount('views')->latest()->get()->append('similar_questions_list');

        return view('forum.question.index', ['questions' => $questions]);
    }

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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateForumQuestionRequest  $request
     * @param  \App\Models\Forum\ForumQuestion  $forumQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForumQuestionRequest $request, ForumQuestion $forumQuestion)
    {
        $this->questionService->update($forumQuestion, $request->text, $request->file('images'));

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Forum\ForumQuestion  $forumQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumQuestion $forumQuestion)
    {
        $this->questionService->destroy($forumQuestion);

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Forum\StoreForumQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function publish(ForumQuestion $forumQuestion)
    {
        $this->questionService->publish($forumQuestion);

        return back();
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
            'moderatedForumAnswers' => fn($q) => $q->withCount('likes')->orderByDesc('likes_count')->orderBy('id')->with([
                'likes',
                'user' => fn($q2) => $q2->select(['id', 'name'])->withCount('moderatedForumAnswers'),
                'moderatedForumComments',
                'moderatedForumComments.user' => fn($q2) => $q2->select(['id', 'name'])->withCount('moderatedForumAnswers'),
            ]),
            'user' => fn($q) => $q->select(['id', 'name'])->withCount('moderatedForumAnswers'),
        ])->loadCount('views');

        $similarQuestions = ForumQuestion::whereIn('id', $forumQuestion->similar_questions)->get();

        $newQuestions = ForumQuestion::where('published', true)->select(['id', 'forum_subcategory_id', 'theme'])
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
