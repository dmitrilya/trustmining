<?php

namespace App\Http\Controllers;

use App\Models\Chat\Chat;
use App\Models\Database\Coin;
use App\Models\Insight\Content\Article;
use App\Models\User\Role;
use Illuminate\View\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home(): View
    {
        $data = Cache::get('home_page_data');
        $data['articles'] = Article::published()->orderByDesc('published_at')->limit(9)->get();

        return view('home.index', $data);
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
}
