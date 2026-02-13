<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;

use App\Http\Traits\ViewTrait;

use App\Models\Blog\BlogArticle;

class BlogArticleController extends Controller
{
    use ViewTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('article.index', ['articles' => BlogArticle::latest()->get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\BlogArticle  $article
     * @return \Illuminate\Http\Response
     */
    public function show(BlogArticle $article)
    {
        $this->addView(request(), $article);

        return view('article.show', ['article' => $article, 'articles' => BlogArticle::where('id', '!=', $article->id)->latest()->take(5)->get()]);
    }
}
