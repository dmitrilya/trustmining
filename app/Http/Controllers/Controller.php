<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Traits\SearchTrait;
use App\Http\Traits\Telegram;
use App\Http\Traits\AdTrait;
use App\Http\Traits\DaData;

use App\Models\Article;
use App\Models\Hosting;
use App\Models\Role;
use App\Models\Chat;
use App\Models\Ad;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SearchTrait, Telegram, AdTrait, DaData;

    public function locale(Request $request)
    {
        if (! in_array($request->locale, ['en', 'ru'])) {
            abort(400);
        }
     
        app()->setLocale($request->locale);
        session()->put('locale', $request->locale);

        return back();
    }

    public function home(): View
    {
        return view('home', [
            'articles' => Article::latest()->take(5)->get(),
            'ads' => $this->getAds()->where('moderation', false)->where('hidden', false)->latest()->take(5)->get(),
            'hostings' => Hosting::where('moderation', false)->latest()->take(5)->get()
        ]);
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
}
