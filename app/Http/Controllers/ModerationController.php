<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

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
        return view('moderation.index', [
            'moderations' => $this->getModerations($request)->get()
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
        if ($moderation->moderation_status_id != 1 && \Auth::user()->role->name != 'admin') return redirect()->route('moderations');

        switch ($moderation->moderationable_type) {
            case ('App\Models\Company'):
                return view('company.show', ['company' => $moderation->moderationable, 'moderation' => $moderation]);
                break;
            case ('App\Models\Hosting'):
                return view('hosting.show', ['hosting' => $moderation->moderationable, 'moderation' => $moderation]);
                break;
            case ('App\Models\Ad'):
                return view('ad.show', ['ad' => $moderation->moderationable, 'moderation' => $moderation]);
                break;
            case ('App\Models\Review'):
                return view('review.show', ['review' => $moderation->moderationable, 'moderation' => $moderation]);
                break;
            case ('App\Models\Office'):
                return view('office.show', ['office' => $moderation->moderationable, 'moderation' => $moderation]);
                break;
            case ('App\Models\Contact'):
                return view('contact.show', ['contact' => $moderation->moderationable, 'moderation' => $moderation]);
                break;
            case ('App\Models\Passport'):
                return view('passport.show', ['passport' => $moderation->moderationable, 'moderation' => $moderation]);
                break;
        }

        return redirect()->route('moderations');
    }

    public function accept(Moderation $moderation)
    {
        if ($moderation->moderation_status_id != 1)
            return redirect()->route('moderations')->withErrors(['forbidden' => __('Not available moderation.')]);

        $m = $moderation->moderationable;

        if ($moderation->moderationable_type == 'App\Models\Company' && (!$m->user->passport || $m->user->passport->moderation))
            return redirect()->route('moderations')->withErrors(['forbidden' => __('First you need to pass moderation by passport')]);

        if (!$m->moderation) {
            $files = [];
            $disk = 'public';

            switch ($moderation->moderationable_type) {
                case ('App\Models\Company'):
                    if (isset($moderation->data['logo']) && $m->logo) array_push($files, $m->logo);
                    if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($m->documents, 'path'));
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('App\Models\Hosting'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($m->documents, 'path'));
                    break;
                case ('App\Models\Ad'):
                    if (isset($moderation->data['preview'])) array_push($files, $m->preview);
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('App\Models\Review'):
                    if (isset($moderation->data['document']) && $m->document) array_push($files, $m->document);
                    if (isset($moderation->data['image']) && $m->image) array_push($files, $m->image);
                    break;
                case ('App\Models\Office'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('App\Models\Passport'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                    $disk = 'private';
                    break;
            }

            Storage::disk($disk)->delete($files);
        }

        $data = $moderation->data;
        if ($m->moderation) $data['moderation'] = 0;
        $m->update($data);

        $moderation->moderation_status_id = 2;
        $moderation->user_id = \Auth::id();
        $moderation->save();

        return redirect()->route('moderations');
    }

    public function decline(Request $request, Moderation $moderation)
    {
        if ($moderation->moderation_status_id != 1) return redirect()->route('moderations');

        $files = [];
        $disk = 'public';

        switch ($moderation->moderationable_type) {
            case ('App\Models\Company'):
                if (isset($moderation->data['logo'])) array_push($files, $moderation->data['logo']);
                if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($moderation->data['documents'], 'path'));
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('App\Models\Hosting'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($moderation->data['documents'], 'path'));
                break;
            case ('App\Models\Ad'):
                if (isset($moderation->data['preview'])) array_push($files, $moderation->data['preview']);
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('App\Models\Review'):
                if (isset($moderation->data['document'])) array_push($files, $moderation->data['document']);
                if (isset($moderation->data['image'])) array_push($files, $moderation->data['image']);
                break;
            case ('App\Models\Office'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('App\Models\Passport'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                $disk = 'private';
                break;
        }

        Storage::disk($disk)->delete($files);

        $moderation->moderation_status_id = 3;
        $moderation->comment = $request->comment;
        $moderation->user_id = \Auth::id();
        $moderation->save();

        if ($moderation->moderationable_type == 'App\Models\Passport') $moderation->moderationable->delete();

        return redirect()->route('moderations');
    }
}
