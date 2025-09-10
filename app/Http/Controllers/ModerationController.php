<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\ModerationTrait;

use App\Models\Moderation;

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
            ->filter(fn($moderation) => $moderation->moderationable && $moderation->moderationable->user)->values();

        return view('moderation.index', [
            'moderations' => $moderations->sortBy(
                fn($moderation, $i) => $moderation->moderationable->user->tariff_id ?
                    $i - floor($moderations->count() / 10 * 3) * $moderation->moderationable->user->tariff_id :
                    $i
            )
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Moderation  $moderation
     * @return \Illuminate\Http\Response
     */
    public function show(Moderation $moderation)
    {
        $m = $moderation->moderationable;

        if ($moderation->moderation_status_id != 1 && \Auth::user()->role->name != 'admin' || !$m || !$m->user)
            return redirect()->route('moderations')->withErrors(['forbidden' => __('Not available moderation')]);

        switch ($moderation->moderationable_type) {
            case ('App\Models\Company'):
                return view('company.show', ['company' => $m, 'moderation' => $moderation]);
                break;
            case ('App\Models\Hosting'):
                return view('hosting.show', ['hosting' => $m, 'moderation' => $moderation]);
                break;
            case ('App\Models\Ad'):
                return view('ad.show', ['ad' => $m, 'moderation' => $moderation]);
                break;
            case ('App\Models\Review'):
                return view('review.show', ['review' => $m, 'moderation' => $moderation]);
                break;
            case ('App\Models\Office'):
                return view('office.show', ['office' => $m, 'moderation' => $moderation]);
                break;
            case ('App\Models\Passport'):
                return view('passport.show', ['passport' => $m, 'moderation' => $moderation]);
                break;
            case ('App\Models\Guide'):
                return view('guide.show', ['guide' => $m, 'moderation' => $moderation]);
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
