<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;

use App\Services\Forum\ForumQuestionService;
use App\Services\Forum\ForumAnswerService;
use App\Services\Forum\ForumAnswerCommentService;

abstract class BaseController extends Controller
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
}