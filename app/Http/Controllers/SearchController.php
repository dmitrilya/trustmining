<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Blog\BlogArticle;
use App\Models\User\Company;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request): JsonResponse
    {
        $q = $request->input('query');
        
        $brands = AsicBrand::search($q)->query(function ($query) {
            $query->select(['id', 'name', 'slug']);
        })->take(3)->get()->map(fn($brand) => [
            'model' => __('Brand'),
            'name' => $brand->name,
            'href' => route('database.asic-miners.brand', ['asicBrand' => $brand->slug])
        ]);

        $models = AsicModel::search($q)->query(function ($query) {
            $query->join('algorithms', 'asic_models.algorithm_id', '=', 'algorithms.id')
                ->join('asic_brands', 'asic_models.asic_brand_id', '=', 'asic_brands.id')
                ->select(['asic_models.id', 'asic_models.name', 'asic_models.slug', 'asic_brands.slug as asic_brand_slug']);
        })->take(5)->get()->map(fn($model) => [
            'model' => __('Model'),
            'name' => $model->name,
            'href' => route('database.asic-miners.model', [
                'asicBrand' => $model->asic_brand_slug,
                'asicModel' => $model->slug
            ])
        ]);

        $articles = BlogArticle::search($q)->query(function ($query) {
            $query->select(['id', 'title']);
        })->take(3)->get()->map(fn($article) => [
            'model' => __('BlogArticle'),
            'name' => $article->title,
            'href' => route('blog.article', ['article' => $article->id . '-' . Str::slug($article->title)])
        ]);

        $companies = Company::search($q)->query(function ($query) {
            $query->join('users', 'companies.user_id', '=', 'users.id')
                ->select(['companies.id', 'companies.name', 'users.slug as user_slug']);
        })->take(3)->get()->map(fn($company) => [
            'model' => __('Company'),
            'name' => $company->name,
            'href' => route('company', ['user' => $company->user_slug])
        ]);

        $sellers = User::search($q)->query(function ($query) {
            $query->whereHas('ads')->select(['users.id', 'users.name', 'users.slug']);
        })->take(3)->get()->map(fn($user) => [
            'model' => __('Seller'),
            'name' => $user->name,
            'href' => route('company', ['user' => $user->slug])
        ]);

        $suggestions = $brands->concat($models)->concat($articles)->concat($companies)->concat($sellers);

        $finalSuggestions = $suggestions->count() > 10 
            ? $suggestions->shuffle()->take(10)->values() 
            : $suggestions;

        return response()->json([
            'success' => true,
            'suggestions' => $finalSuggestions
        ], 200);
    }
}
