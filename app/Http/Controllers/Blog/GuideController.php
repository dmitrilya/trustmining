<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;

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

        if (!$user->tariff || !$user->tariff->can_create_guide) return back()->withErrors(['forbidden' => __('Not available with current plan')]);

        $guide = Guide::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'guide' => $request->guide,
            'preview' => '',
            'tags' => $request->tags || [],
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
        $user = \Auth::user();

        if ((!$user || $user->role->name == 'user' && $user->id != $guide->user_id) && $guide->moderation)
            return back()->withErrors(['forbidden' => __('Unavailable ad.')]);

        $this->addView(request(), $guide);

        return view('guide.show', [
            'guide' => $guide,
            'guides' => Guide::select(['id', 'user_id', 'title', 'subtitle', 'preview', 'created_at'])
                ->where('moderation', false)->whereNot('id', $guide->id)->withCount(['likes' => function (Builder $q) {
                    $q->where('created_at', '>', Carbon::now()->subWeek());
                }])->orderBy('likes_count', 'desc')->take(5)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGuideRequest  $request
     * @param  \App\Models\Blog\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGuideRequest $request, Guide $guide)
    {
        if ($guide->moderations()->where('moderation_status_id', 1)->exists())
            return back()->withErrors(['forbidden' => __('Unavailable, currently under moderation')]);

        $data = [];

        if ($request->title != $guide->title) $data['title'] = $request->title;
        if ($request->subtitle != $guide->subtitle) $data['subtitle'] = $request->subtitle;
        if ($request->guide != $guide->guide) $data['guide'] = $request->guide;
        if ($request->preview) $data['preview'] = $this->saveFile($request->file('preview'), 'guides', 'preview', $guide->id);

        $tags = $request->tags ? $request->tags : [];
        if (count(array_diff($guide->tags, $tags)) || count(array_diff($tags, $guide->tags))) $data['tags'] = $tags;

        if (!empty($data))
            Moderation::create([
                'moderationable_type' => 'App\Models\Blog\Guide',
                'moderationable_id' => $guide->id,
                'data' => $data
            ]);

        return redirect()->route('guide', ['user' => $guide->user_id, 'guide' => $guide->id . '-' . mb_strtolower(str_replace(' ', '-', $guide->title))]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guide $guide)
    {
        $files = [$guide->preview];

        foreach ($guide->moderations()->where('moderation_status_id', 1)->get() as $moderation) {
            if (array_key_exists('preview', $moderation->data)) array_push($files, $moderation->data['preview']);
        }

        Storage::disk('public')->delete($files);

        $guide->moderations()->where('moderation_status_id', 1)->update(['moderation_status_id' => 4]);

        $guide->delete();

        return redirect()->route('guides')->withErrors(['success' => __('The guide has been removed')]);
    }
}
