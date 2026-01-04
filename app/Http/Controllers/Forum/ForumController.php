<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;

use App\Services\Forum\ForumQuestionService;
use App\Services\Forum\ForumAnswerService;
use App\Services\Forum\ForumCommentService;

use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumSubcategory;
use App\Models\Forum\ForumQuestion;

class ForumController extends Controller
{
    use FileTrait;

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
        $categories = ForumCategory::with(['forumSubcategories' => fn($q) => $q->withCount('publishedForumQuestions')
            ->with(['latestForumQuestion' => fn($q2) => $q2->select(['forum_questions.forum_subcategory_id', 'created_at'])])
            ->orderByDesc('moderated_forum_questions_count')])->get()->map(function ($category) {
            $category->moderated_forum_questions_count = $category->forumSubcategories->sum('moderated_forum_questions_count');
            return $category;
        })->sortByDesc('moderated_forum_questions_count');
        $questions = ForumQuestion::where('published', true)->select(['id', 'forum_subcategory_id', 'theme', 'created_at'])
            ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
            ->withCount('moderatedForumAnswers')->withCount('views')->latest()->limit(5)->get();

        return view('forum.index', ['categories' => $categories, 'questions' => $questions]);
    }

    public function category(ForumCategory $forumCategory): View
    {
        $subcategories = $forumCategory->forumSubcategories()->withCount('publishedForumQuestions')->orderByDesc('moderated_forum_questions_count')
            ->with(['latestForumQuestion' => fn($q) => $q->select(['forum_questions.forum_subcategory_id', 'created_at'])])->get();
        $questions = ForumQuestion::where('published', true)->whereIn('forum_subcategory_id', $subcategories->pluck('id'))
            ->select(['id', 'forum_subcategory_id', 'theme', 'created_at'])
            ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
            ->withCount('moderatedForumAnswers')->withCount('views')->latest()->limit(5)->get();

        return view('forum.category', ['category' => $forumCategory, 'subcategories' => $subcategories, 'questions' => $questions]);
    }

    public function subcategory(ForumCategory $forumCategory, ForumSubcategory $forumSubcategory): View
    {
        $questions = $forumSubcategory->publishedForumQuestions()->select(['id', 'forum_subcategory_id', 'theme', 'created_at'])
            ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
            ->withCount('moderatedForumAnswers')->withCount('views')->latest()->paginate(30);

        return view('forum.subcategory', ['category' => $forumCategory, 'subcategory' => $forumSubcategory, 'questions' => $questions]);
    }

    public function updateAvatar(Request $request)
    {
        $this->saveFile($request->file('avatar'), 'forum', 'avatar', $request->user()->id, 'public/', 80, false);

        return back();
    }
}
