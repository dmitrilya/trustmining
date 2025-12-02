<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

use App\Services\Forum\ForumQuestionService;
use App\Services\Forum\ForumAnswerService;
use App\Services\Forum\ForumCommentService;

use App\Models\Forum\ForumCategory;
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
        $categories = ForumCategory::with(['forumSubcategories' => fn($q) => $q->withCount('moderatedForumQuestions')])->get();
        $questions = ForumQuestion::where('moderation', false)->limit(10)->get();

        return view('forum.index', ['categories' => $categories, 'questions' => $questions]);
    }

    public function category(ForumCategory $forumcategory): View
    {
        $subcategories = $forumcategory->forumSubcategories()->withCount('moderatedForumQuestions')->get();
        $questions = $forumcategory->moderatedForumQuestions()->limit(10)->get();

        return view('forum.index', ['subcategories' => $subcategories, 'questions' => $questions]);
    }
}