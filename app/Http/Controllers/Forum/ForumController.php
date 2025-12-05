<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

use App\Services\Forum\ForumQuestionService;
use App\Services\Forum\ForumAnswerService;
use App\Services\Forum\ForumCommentService;

use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumSubcategory;
use App\Models\Forum\ForumQuestion;

class ForumController extends Controller
{
    protected $questionService;
    protected $answerService;
    protected $commentService;

    public function __construct(ForumQuestionService $questionService, ForumAnswerService $answerService, ForumCommentService $commentService)
    {
        $this->questionService = $questionService;
        $this->answerService = $answerService;
        $this->commentService = $commentService;
    }

    public function index(): View
    {
        $categories = ForumCategory::with(['forumSubcategories' => fn($q) => $q->withCount('moderatedForumQuestions')->orderByDesc('moderated_forum_questions_count')])
            ->get()->map(function ($category) {
                $category->moderated_forum_questions_count = $category->forumSubcategories->sum('moderated_forum_questions_count');
                return $category;
            })->sortByDesc('moderated_forum_questions_count');
        $questions = ForumQuestion::where('moderation', false)->limit(10)->get();

        return view('forum.index', ['categories' => $categories, 'questions' => $questions]);
    }

    public function category(ForumCategory $forumCategory): View
    {
        $subcategories = $forumCategory->forumSubcategories()->withCount('moderatedForumQuestions')->get();
        $questions = $forumCategory->moderatedForumQuestions()->limit(10)->get();

        return view('forum.category', ['category' => $forumCategory, 'subcategories' => $subcategories, 'questions' => $questions]);
    }

    public function subcategory(ForumCategory $forumCategory, ForumSubcategory $forumSubcategory): View
    {
        $questions = $forumSubcategory->moderatedForumQuestions()->paginate(30);

        return view('forum.subcategory', ['category' => $forumCategory, 'subcategory' => $forumSubcategory, 'questions' => $questions]);
    }
}
