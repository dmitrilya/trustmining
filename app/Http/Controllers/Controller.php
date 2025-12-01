<?php

namespace App\Http\Controllers;

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

use App\Models\Database\Algorithm;
use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Morph\Like;
use App\Models\User\Role;
use App\Models\Database\Coin;
use App\Models\Chat\Chat;

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

    public function calculator(AsicModel $asicModel, AsicVersion $asicVersion): View
    {
        $measurements = ['h', 'kh', 'Mh', 'Gh', 'Th', 'Ph', 'Eh', 'Zh'];
        $algorithms = Algorithm::select(['id'])->with([
            'coins' => fn($q) => $q->where('profit', '>', 0)->where('rate', '>', 0)
                ->select(['abbreviation', 'name', 'algorithm_id', 'profit', 'rate', 'merged_group'])
        ])->get()->map(function ($algorithm) {
            $algorithm['maxProfit'] = $algorithm->coins->groupBy('merged_group')->map(
                fn($mergedGroup) => [
                    'profit' => $mergedGroup->sum(fn($coin) => $coin->profit * $coin->rate),
                    'coins' => $mergedGroup
                ]
            )->sortByDesc('profit')->values();

            return $algorithm;
        });

        if (Cache::has('calculator_models')) $models = Cache::get('calculator_models');
        else {
            $models = AsicModel::select(['id', 'name', 'algorithm_id', 'asic_brand_id'])->with([
                'algorithm:id,name,measurement',
                'asicBrand:id,name',
                'asicVersions:id,hashrate,asic_model_id,efficiency,measurement',
                'asicVersions.ads:asic_version_id,price,coin_id',
                'asicVersions.ads.coin:id,rate,abbreviation',
                'moderatedReviews:reviewable_id,reviewable_type,rating'
            ])->get()->map(function ($model) use ($measurements, $algorithms) {
                $algorithm = $algorithms->where('id', $model->algorithm->id)->first();

                $model->asicVersions->map(function ($version) use ($measurements, $algorithm, $model) {
                    $vm = array_search($version->measurement, $measurements);
                    $am = array_search($model->algorithm->measurement, $measurements);
                    $version->profits = $algorithm->maxProfit->map(fn($profit) => [
                        'profit' => round($profit['profit'] * $version->hashrate * pow(1000, $vm - $am), 4),
                        'coins' => $profit['coins']
                    ]);
                    $version->price = round($version->ads->avg(fn($ad) => $ad->price * $ad->coin->rate), 2);
                    $version->algorithm = $model->algorithm->name;
                    $version->brand_name = strtolower(str_replace(' ', '_', $model->asicBrand->name));
                    $version->model_name = strtolower(str_replace(' ', '_', $model->name));
                    $version->reviews_count = $model->moderatedReviews->count();
                    $version->reviews_avg = $model->moderatedReviews->avg('rating');

                    return $version;
                });

                return $model;
            });

            Cache::put('calculator_models', $models, 300);
        }

        return view('calculator.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel->name,
            'rVersion' => $asicVersion->hashrate,
        ]);
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
        if (!call_user_func_array([$request->likeableType, 'find'], [$request->likeableId]))
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
