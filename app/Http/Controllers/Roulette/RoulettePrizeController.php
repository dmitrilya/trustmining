<?php

namespace App\Http\Controllers\Roulette;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roulette\StoreRoulettePrizeRequest;
use App\Http\Requests\Roulette\UpdateRoulettePrizeRequest;
use Illuminate\Support\Str;

use App\Models\Roulette\RoulettePrize;
use App\Models\User\User;

class RoulettePrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prizes = RoulettePrize::with('user.company')->latest()->get();
        $users = User::whereHas('company', fn($q) => $q->where('moderation', false))->select(['id', 'name'])->get()
            ->map(fn($user) => ['key' => $user->id, 'value' => __($user->name)])->keyBy('key');

        return view('roulette.index', [
            'prizes' => $prizes,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Roulette\StoreRoulettePrizeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoulettePrizeRequest $request)
    {
        RoulettePrize::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'caption' => $request->caption,
            'partner_link' => $request->partner_link,
            'href' => $request->href,
            'chance' => $request->chance,
        ]);

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Roulette\UpdateRoulettePrizeRequest  $request
     * @param  \App\Models\Roulette\RoulettePrize  $roulettePrize
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoulettePrizeRequest $request, RoulettePrize $roulettePrize)
    {
        $roulettePrize->update($request->all());

        return back();
    }

    /**
     * Toggle active
     * 
     * @param  \App\Models\Roulette\RoulettePrize  $roulettePrize
     * @return \Illuminate\Http\Response
     */
    public function toggleActive(RoulettePrize $roulettePrize)
    {
        if (!$roulettePrize->deactivated_at) {
            if ($roulettePrize->activated_at) $roulettePrize->update(['deactivated_at' => now()]);
            else $roulettePrize->update(['activated_at' => now()]);
        }

        return back();
    }

    /**
     * Download user's tg ids
     * 
     * @param  \App\Models\Roulette\RoulettePrize  $roulettePrize
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function downloadResults(RoulettePrize $roulettePrize)
    {
        $user = auth()->user();

        if ($user->id != $roulettePrize->user_id && !in_array($user->role->name, ['admin', 'support', 'moderator'])) return response()->json([
            'message' => __('No Access.')
        ], 422);

        $tgIds = $roulettePrize->rouletteSpins()->whereNotNull('user_id')->with('user:id,tg_id')
            ->get()->pluck('user.tg_id')->filter()->unique()->implode("\n");

        if (empty($tgIds)) return response()->json([
            'message' => __('No Telegram IDs found for this prize.')
        ], 422);

        $safePrizeName = Str::slug($roulettePrize->name, '_');
        $fileName = "tg_ids_{$safePrizeName}_" . now()->format('Y_m_d_His') . '.txt';

        return response($tgIds, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'no-cache, private',
        ]);
    }
}
