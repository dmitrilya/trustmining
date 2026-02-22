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
use App\Http\Traits\AdTrait;
use App\Http\Traits\DaData;

use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Morph\Like;
use App\Models\User\Role;
use App\Models\Database\Coin;
use App\Models\Chat\Chat;
use App\Models\User\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SearchTrait, Telegram, AdTrait, DaData;

    public function home(): View
    {
        return view('home');
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
            ->sortByDesc(fn($model) => $model->asicVersions->first()->profits->first()['profit'])->take(15)->map(function ($model) {
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

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();
        dd($selModel, $selVersion);

        return view('calculator.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
        ]);
    }

    public function calculatorApp(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): View
    {
        $models = Cache::get('calculator_models');

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();

        return view('calculator.app', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
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
