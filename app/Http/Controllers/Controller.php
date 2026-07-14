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

use App\Http\Traits\AdTrait;
use App\Http\Traits\DaData;
use App\Http\Traits\SearchTrait;

use App\Models\Database\Coin;
use App\Models\Morph\Like;
use App\Models\User\Role;
use App\Models\User\User;
use App\Models\Chat\Chat;
use App\Models\Insight\Content\Article;
use App\Models\Morph\Track;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AdTrait, DaData, SearchTrait;

    public function home(): View
    {
        $data = Cache::get('home_page_data');
        $data['articles'] = Article::where('moderation', false)->orderByDesc('created_at')->limit(9)->get();

        return view('home.index', $data);
    }

    public function about(): View
    {
        return view('about');
    }

    public function document(): View
    {
        return view('document');
    }

    public function privacy(): View
    {
        return view('document');
    }

    public function terms(): View
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

    public function api(): View
    {
        return view('api.index');
    }

    public function legal(): View
    {
        return view('legal.index');
    }

    public function taxes(): View
    {
        return view('taxes.index');
    }

    public function widjets(): View
    {
        $models = Cache::get('calculator_models');

        $selModel = $models->where('name', 'Antminer L9')->first();
        $selVersion = $selModel->asicVersions->first();

        return view('widjets.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
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

        $ads = $this->getAds()->whereIn('asic_models.id', $models->pluck('id'))->orderByDesc('ads.ordering_id')->get();

        $models = $models->map(function ($model) use ($ads) {
            $version = $model->asicVersions->first();
            $ad = $ads->where('asic_model_slug', $model->slug)->where('asic_version_hashrate', $version->hashrate)->where('price', '!=', 0)
                ->sortBy(fn($ad) => $ad->price * $ad->coin_rate)->first();
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
                'min_price' => $ad ? $ad->price * $ad->coin_rate : null,
                'min_price_text' => $ad ? $ad->price . ' ' . $ad->coin : null,
            ];
        })->values();

        return view('profitable.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
            'ads' => $ads->whereIn('asic_model_slug', $models->take(5)->pluck('slug'))->take(14)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        $modelClass = Relation::getMorphedModel($request->trackable_type);
        if (!$modelClass || !($modelClass::find($request->trackable_id)))
            return response()->json(['success' => false, 'message' => __('Not available')]);

        $user = $request->user();

        // if (!$user || !$user->tariff) return response()->json(['success' => false, 'message' => __('This feature is only available with a subscription')]);

        if ($track = $user->tracks()->where('trackable_type', $request->trackable_type)->where('trackable_id', $request->trackable_id)->first()) {
            $track->delete();
            $tracking = false;
            $message = 'You have unsubscribed from notifications.';
        } else {
            Track::create([
                'trackable_type' => $request->trackable_type,
                'trackable_id' => $request->trackable_id,
                'user_id' => $user->id
            ]);
            $tracking = true;
            $message = 'You have successfully subscribed to price change notifications.';
        }

        return response()->json([
            'success' => true,
            'tracking' => $tracking,
            'message' => __($message)
        ]);
    }
}
