<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
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
            'asicBrands' => AsicBrand::select(['id', 'name'])->withCount('views')->orderByDesc('views_count')->get(),
            'asicModels' => AsicModel::select(['id', 'name', 'asic_brand_id'])->with(['asicBrand:id,name'])
                ->withCount('views')->orderByDesc('views_count')->limit(10)->get(),
            'gpuModels' => GPUModel::select(['id', 'name', 'images', 'max_power', 'gpu_brand_id'])->with(['gpuBrand:id,name'])
                ->withCount('ads')->orderByDesc('ads_count')->limit(9)->get(),
            'miners' => $miners->orderByDesc('ads.ordering_id')->limit(9)->get(),
            'hostings' => $this->getHostings(null)->orderByDesc('ordering_id')->limit(9)->get(),
            'articles' => Article::where('moderation', false)->orderByDesc('created_at')->limit(9)->get(),
            'forumQuestions' => ForumQuestion::where('published', true)->select(['id', 'forum_subcategory_id', 'theme', 'created_at'])
                ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
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

    public function top(): View
    {
        return view('top.index', ['users' => User::select(['id', 'name', 'url_name', 'tf', 'tariff_id'])->orderByDesc('tf')->limit(10)
            ->with(['company:user_id,logo,card,moderation', 'moderatedReviews', 'passport:moderation'])->get()]);
    }

    public function asicRating(): View
    {
        $models = Cache::get('calculator_models')->filter(fn($model) => count($model->asicVersions->first()->profits))
            ->sortByDesc(fn($model) => $model->asicVersions->first()->profits->first()['profit'])->take(50)->map(function ($model) {
                $version = $model->asicVersions->first();
                $profit = $version->profits->first();

                return [
                    'name' => $model->name,
                    'url_name' => $version->model_name,
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
                    'brand' => $version->brand_name
                ];
            })->values();

        return view('profitable', ['models' => $models, 'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate]);
    }

    public function calculator(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): View
    {
        $models = Cache::get('calculator_models');

        if ($asicModel && $asicModel->exists) $this->addView(request(), $asicModel);

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();
        $ads = $this->getAds()->where('ads.asic_version_id', $selVersion->id)
            ->orderByRaw('ads.price = 0 ASC')->orderByRaw("ads.price * coins.rate ASC")->limit(9)->get();

        return view('calculator.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'ads' => $ads
        ]);
    }

    public function calculatorApp(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): View
    {
        $models = Cache::get('calculator_models');

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();
        $ads = $this->getAds()->where('ads.asic_version_id', $selVersion->id)
            ->orderByRaw('ads.price = 0 ASC')->orderByRaw("ads.price * coins.rate ASC")->limit(9)->get();

        return view('calculator.app', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'ads' => $ads
        ]);
    }

    public function calculatorModels()
    {
        return response()->json(Cache::get('calculator_models'), 200);
    }

    public function support(): View
    {
        $auth = \Auth::user();
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
