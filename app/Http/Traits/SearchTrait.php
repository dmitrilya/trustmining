<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
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
            $query->select(['asic_brands.name', 'asic_brands.slug']);
        })->get()->map(fn($asicBrand) => [
            'model' => __('Brand'),
            'name' => $asicBrand->name,
            'href' => route('database.asic-miners.brand', ['asicBrand' => $asicBrand->slug])
        ])->concat(AsicModel::search($q)->query(function ($query) {
            $query->join('algorithms', 'asic_models.algorithm_id', 'algorithms.id')
                ->join('asic_brands', 'asic_models.asic_brand_id', 'asic_brands.id')
                ->select(['asic_models.id', 'asic_models.name', 'asic_models.slug', 'asic_brands.slug as asic_brand_slug']);
        })->get()->map(fn($asicModel) => [
            'model' => __('Model'),
            'name' => $asicModel->name,
            'href' => route('database.asic-miners.model', [
                'asicBrand' => $asicModel->asic_brand_slug,
                'asicModel' => $asicModel->slug
            ])
        ]))->concat(BlogArticle::search($q)->query(function ($query) {
            $query->select(['blog_articles.title']);
        })->get()->map(fn($article) => [
            'model' => __('BlogArticle'),
            'name' => $article->title,
            'href' => route('blog.article', ['article' => $article->id . '-' . Str::slug($article->title)])
        ]))->concat(Company::search($q)->query(function ($query) {
            $query->join('users', 'companies.user_id', 'users.id')
                ->select(['companies.id', 'companies.name', 'users.slug as user_slug']);
        })->get()->map(fn($company) => [
            'model' => __('Company'),
            'name' => $company->name,
            'href' => route('company', ['user' => $company->user_slug])
        ]))->concat(User::search($q)->query(function ($query) {
            $query->whereHas('ads')->select(['users.name', 'users.slug']);
        })->get()->map(fn($user) => [
            'model' => __('Seller'),
            'name' => $user->name,
            'href' => route('company', ['user' => $user->slug])
        ]));

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions->count() > 10 ? $suggestions->random(10) : $suggestions
        ], 200);
    }
}
