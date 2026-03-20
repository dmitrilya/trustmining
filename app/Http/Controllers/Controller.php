<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Traits\SearchTrait;
use App\Http\Traits\Telegram;
use App\Http\Traits\HostingTrait;
use App\Http\Traits\AdTrait;
use App\Http\Traits\DaData;
use App\Http\Traits\ViewTrait;

use App\Models\Ad\AdCategory;
use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Database\GPUModel;
use App\Models\Database\Coin;
use App\Models\Morph\Like;
use App\Models\User\Role;
use App\Models\User\User;
use App\Models\Chat\Chat;
use App\Models\Forum\ForumQuestion;
use App\Models\Insight\Channel;
use App\Models\Insight\Content\Article;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SearchTrait, Telegram, AdTrait, HostingTrait, DaData, ViewTrait;

    public function home(): View
    {
        $location = session('user_location');
        $miners = $this->getAds(null, AdCategory::where('name', 'miners')->first());

        if ($location && $location['source'] == 'geo') $miners->orderByRaw("CASE WHEN offices.city = ? THEN 1 ELSE 0 END DESC", [$location['city']]);

        return view('home.index', [
            'asicBrands' => AsicBrand::select(['id', 'name', 'slug'])->withCount('views')->orderByDesc('views_count')->get(),
            'asicModels' => AsicModel::select(['id', 'name', 'slug', 'asic_brand_id'])->with(['asicBrand:id,name,slug'])
                ->withCount('views')->orderByDesc('views_count')->limit(10)->get(),
            'gpuModels' => GPUModel::select(['id', 'name', 'slug', 'images', 'max_power', 'gpu_brand_id'])->with(['gpuBrand:id,name,slug'])
                ->withCount('ads')->orderByDesc('ads_count')->limit(9)->get(),
            'miners' => $miners->orderByDesc('ads.ordering_id')->limit(9)->get(),
            'hostings' => $this->getHostings(null)->inRandomOrder()->limit(9)->get(),
            'articles' => Article::where('moderation', false)->orderByDesc('created_at')->limit(9)->get(),
            'forumQuestions' => ForumQuestion::where('published', true)->select(['id', 'forum_subcategory_id', 'theme', 'created_at'])
                ->with(['forumSubcategory:id,name,slug,forum_category_id', 'forumSubcategory.forumCategory:id,name,slug'])
                ->withCount('moderatedForumAnswers')->withCount('views')->latest()->limit(3)->get(),
            'topChannels' => Channel::select(['id', 'name', 'slug', 'logo'])->withCount('activeSubscribers')->orderByDesc('active_subscribers_count')->limit(4)->get()
        ]);
    }

    public function about(): View
    {
        return view('about');
    }

    public function document(): View
    {
        return view('document');
    }

    public function roadmap(): View
    {
        return view('roadmap');
    }

    public function career(): View
    {
        return view('career');
    }

    public function events(): View
    {
        return view('events');
    }

    public function warranty(): View
    {
        return view('warranty.index');
    }

    public function widjets(): View
    {
        $models = Cache::get('calculator_models');

        $selModel = $models->where('name', 'Antminer L9')->first();
        $selVersion = $selModel->asicVersions->first();

        return view('widjets.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => null,
            'rVersion' => null,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
        ]);
    }

    public function top(): View
    {
        return view('top.index', ['users' => User::select(['id', 'name', 'slug', 'tf', 'tariff_id'])->orderByDesc('tf')->limit(10)
            ->with(['company:user_id,logo,card,moderation', 'moderatedReviews', 'passport:moderation'])->get()]);
    }

    public function asicRating(): View
    {
        $models = Cache::get('calculator_models')->filter(fn($model) => count($model->asicVersions->first()->profits))
            ->sortByDesc(fn($model) => $model->asicVersions->first()->profits->first()['profit'])->take(50);

        $ads = $this->getAds()->whereIn('asic_models.id', $models->take(5)->pluck('id'))->orderByDesc('ads.ordering_id')->get();

        $models = $models->map(function ($model) use ($ads) {
            $version = $model->asicVersions->first();
            $ad = $ads->where('asic_model_slug', $model->slug)->where('asic_version_hashrate', $version->hashrate)->sortBy(fn ($ad) => $ad->price * $ad->coin_rate)->first();
            $profit = $version->profits->first();

            return [
                'id' => $model->id,
                'name' => $model->name,
                'slug' => $version->model_slug,
                'hashrate' => $version->hashrate,
                'original_hashrate' => $version->original_hashrate,
                'profit' => $profit ? $profit['profit'] : 0,
                'coins' => $profit ? $profit['coins']->pluck('abbreviation') : [],
                'power' => $version->hashrate * $version->efficiency,
                'efficiency' => $version->efficiency,
                'original_efficiency' => $version->original_efficiency,
                'algorithm' => $version->algorithm,
                'measurement' => $version->measurement,
                'original_measurement' => $model->algorithm->measurement,
                'release' => $model->release,
                'brand_slug' => $version->brand_slug,
                'min_price' => $ad ? $ad->price . ' ' . $ad->coin : null
            ];
        })->values();

        return view('profitable.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'ads' => $ads->take(14)
        ]);
    }

    public function support(): View
    {
        /** @var \App\Models\User\User $auth */
        $auth = Auth::user();
        $chat = null;

        if ($auth) {
            $supportIds = Role::where('name', 'support')->first()->users()->pluck('id');

            $chat = $auth->chats()->whereHas('users', function ($query) use ($supportIds) {
                $query->whereIn('id', $supportIds);
            })->with('messages')->first();

            if (!$chat) {
                $chat = Chat::create();

                $chat->users()->attach([$auth->id, $supportIds->random()]);
            }
        }

        return view('support.index', compact(['auth', 'chat']));
    }

    public function like(Request $request)
    {
        $modelClass = Relation::getMorphedModel($request->likeableType);
        if (!$modelClass || !($modelClass::find($request->likeableId)))
            return response()->json(['success' => false, 'message' => __('Not available')]);

        $user = $request->user();

        if ($like = $user->likes()->where('likeable_type', $request->likeableType)->where('likeable_id', $request->likeableId)->first())
            $like->delete();
        else Like::create([
            'likeable_type' => $request->likeableType,
            'likeable_id' => $request->likeableId,
            'user_id' => $user->id
        ]);

        return response()->json(['success' => true], 200);
    }
}
