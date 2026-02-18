<?php

namespace App\Http\Controllers\Morph;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Traits\ModerationTrait;

use App\Models\Morph\Moderation;

class ModerationController extends Controller
{
    use ModerationTrait;

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request;
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $moderations = $this->getModerations($request)->get()
            ->filter(fn($moderation) => $moderation->moderationable && ($moderation->moderationable->user || $moderation->moderationable->channel))->values();

        return view('moderation.index', [
            'moderations' => $moderations->sortBy(function ($moderation, $i) use ($moderations) {
                $user = $moderation->moderationable->user ? $moderation->moderationable->user : $moderation->moderationable->channel->user;
                return $user->tariff_id ? $i - floor($moderations->count() / 10 * 3) * $user->tariff_id : $i;
            })
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Morph\Moderation  $moderation
     * @return \Illuminate\Http\Response
     */
    public function show(Moderation $moderation)
    {
        $m = $moderation->moderationable;

        if ($moderation->moderation_status_id != 1 && Auth::user()->role->name != 'admin' || !$m || !$m->user && !$m->channel)
            return redirect()->route('moderations')->withErrors(['forbidden' => __('Not available moderation')]);

        switch ($moderation->moderationable_type) {
            case ('company'):
                return view('company.show', ['company' => $m, 'moderation' => $moderation]);
                break;
            case ('hosting'):
                return view('hosting.show', ['hosting' => $m, 'moderation' => $moderation]);
                break;
            case ('ad'):
                return view('ad.show', ['ad' => $m, 'moderation' => $moderation]);
                break;
            case ('review'):
                return view('review.show', ['review' => $m, 'moderation' => $moderation]);
                break;
            case ('office'):
                return view('office.show', ['office' => $m, 'moderation' => $moderation]);
                break;
            case ('passport'):
                return view('passport.show', ['passport' => $m, 'moderation' => $moderation]);
                break;
            case ('article'):
                return view('insight.article.show', ['article' => $m, 'moderation' => $moderation]);
                break;
            case ('post'):
                return view('insight.post.show', ['post' => $m, 'moderation' => $moderation]);
                break;
            case ('video'):
                return view('insight.video.show', ['video' => $m, 'moderation' => $moderation]);
                break;
        }

        return redirect()->route('moderations');
    }

    public function accept(Request $request, Moderation $moderation)
    {
        return $this->acceptModeration($request->filled('unique_content'), $moderation);
    }

    public function decline(Request $request, Moderation $moderation)
    {
        return $this->declineModeration($request->comment, $moderation);
    }
}
