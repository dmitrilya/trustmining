<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

use App\Services\Forum\ForumQuestionService;
use App\Services\Forum\ForumAnswerService;
use App\Services\Forum\ForumAnswerCommentService;

use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumQuestion;

class ForumController extends Controller
{
    protected $questionService;
    protected $answerService;
    protected $answerCommentService;

    public function __construct(ForumQuestionService $questionService, ForumAnswerService $answerService, ForumAnswerCommentService $answerCommentService)
    {
        $this->questionService = $questionService;
        $this->answerService = $answerService;
        $this->answerCommentService = $answerCommentService;
    }

    public function index(): View
    {
        $categories = ForumCategory::with(['forumSubcategories' => fn($q) => $q->withCount('forumQuestions')])->get();
        $questions = ForumQuestion::limit(10)->get();

        return view('forum.index', ['categories' => $categories, 'questions' => $questions]);
    }

    public function category(ForumCategory $forumcategory): View
    {
        $subcategories = $forumcategory->forumSubcategories()->withCount('forumQuestions')->get();
        $questions = $forumcategory->forumQuestions()->limit(10)->get();

        return view('forum.index', ['subcategories' => $subcategories, 'questions' => $questions]);
    }
}