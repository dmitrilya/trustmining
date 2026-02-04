<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;

use App\Http\Traits\ViewTrait;

use App\Models\Blog\Article;

class ArticleController extends Controller
{
    use ViewTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('article.index', ['articles' => Article::latest()->get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->addView(request(), $article);

        return view('article.show', ['article' => $article, 'articles' => Article::where('id', '!=', $article->id)->latest()->take(5)->get()]);
    }
}
