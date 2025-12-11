<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGuideRequest;

use App\Http\Traits\FileTrait;
use App\Http\Traits\GuideTrait;
use App\Http\Traits\ViewTrait;

use App\Models\Morph\Moderation;
use App\Models\Blog\Guide;
use App\Models\User\User;

use Carbon\Carbon;

class GuideController extends Controller
{
    use ViewTrait, FileTrait, GuideTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('guide.index', [
            'guides' => $this->getGuides($request)->paginate(30),
            'tags' => Guide::pluck('tags')->flatten()->groupBy(fn($tag) => $tag)->sortByDesc(fn($tagGroup) => $tagGroup->count())->keys()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGuideRequest $request)
    {
        $user = $request->user();

        //if ($user->tariff && $user->ads()->count() >= $user->tariff->max_ads || !$user->tariff && $user->ads()->count() >= 2)
        //    return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $guide = Guide::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'guide' => $request->guide,
            'preview' => '',
            'tags' => $request->tags,
        ]);

        $guide->preview = $this->saveFile($request->file('preview'), 'guides', 'preview', $guide->id);
        $guide->save();

        Moderation::create([
            'moderationable_type' => 'App\Models\Blog\Guide',
            'moderationable_id' => $guide->id,
            'data' => $guide->attributesToArray()
        ]);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Guide $guide)
    {
        $this->addView(request(), $guide);

        return view('guide.show', [
            'guide' => $guide,
            'guides' => Guide::select(['id', 'user_id', 'title', 'subtitle', 'preview', 'created_at'])
                ->where('moderation', false)->whereNot('id', $guide->id)->withCount(['likes' => function (Builder $q) {
                    $q->where('created_at', '>', Carbon::now()->subWeek());
                }])->orderBy('likes_count', 'desc')->take(5)->get()
        ]);
    }
}
