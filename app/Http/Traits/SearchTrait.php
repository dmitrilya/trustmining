<?php

namespace App\Http\Traits;

use App\Http\Requests\SearchRequest;

use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Blog\BlogArticle;
use App\Models\User\Company;
use App\Models\User\User;

trait SearchTrait
{
    public function search(SearchRequest $request)
    {
        $q = $request->input('query');
        $suggestions = AsicBrand::search($q)->query(function ($query) {
            $query->select(['asic_brands.name']);
        })->get()->map(fn($asicBrand) => [
            'model' => __('Brand'),
            'name' => $asicBrand->name,
            'href' => route('database.brand', ['asicBrand' => strtolower(str_replace(' ', '_', $asicBrand->name))])
        ])->concat(AsicModel::search($q)->query(function ($query) {
            $query->join('algorithms', 'asic_models.algorithm_id', 'algorithms.id')
                ->join('asic_brands', 'asic_models.asic_brand_id', 'asic_brands.id')
                ->select(['asic_models.id', 'asic_models.name', 'asic_brands.name as asic_brand_name']);
        })->get()->map(fn($asicModel) => [
            'model' => __('Model'),
            'name' => $asicModel->name,
            'href' => route('database.model', [
                'asicBrand' => strtolower(str_replace(' ', '_', $asicModel->asic_brand_name)),
                'asicModel' => strtolower(str_replace(' ', '_', $asicModel->name))
            ])
        ]))->concat(BlogArticle::search($q)->query(function ($query) {
            $query->select(['blog_articles.title']);
        })->get()->map(fn($article) => [
            'model' => __('BlogArticle'),
            'name' => $article->title,
            'href' => route('blog.article', ['article' => $article->id . '-' . mb_strtolower(str_replace(' ', '-', $article->title))])
        ]))->concat(Company::search($q)->query(function ($query) {
            $query->join('users', 'companies.user_id', 'users.id')
                ->select(['companies.id', 'companies.name', 'users.url_name as user_url_name']);
        })->get()->map(fn($company) => [
            'model' => __('Company'),
            'name' => $company->name,
            'href' => route('company', ['user' => $company->user_url_name])
        ]))->concat(User::search($q)->query(function ($query) {
            $query->whereHas('ads')->select(['users.name', 'users.url_name']);
        })->get()->map(fn($user) => [
            'model' => __('Seller'),
            'name' => $user->name,
            'href' => route('company', ['user' => $user->url_name])
        ]));

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions->count() > 10 ? $suggestions->random(10) : $suggestions
        ], 200);
    }
}
