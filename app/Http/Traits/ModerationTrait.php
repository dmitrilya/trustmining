<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

use App\Http\Traits\NotificationTrait;

use App\Models\Morph\Moderation;

trait ModerationTrait
{
    use NotificationTrait;

    public function getModerations($request)
    {
        $moderations = Moderation::where('moderation_status_id', 1)->select(['id', 'moderationable_type', 'moderationable_id', 'created_at'])
            ->with(['moderationable:id,user_id', 'moderationable.user:id,name,tariff_id', 'moderationable.user.company:user_id,logo']);

        if ($request->model)
            $moderations = $moderations->where('moderationable_type', 'like', '%' . $request->model);

        return $moderations;
    }

    public function acceptModeration($isUniqueContent, $moderation, $userId = null)
    {
        $userId = $userId ? $userId : \Auth::id();

        $m = $moderation->moderationable;

        if ($moderation->moderation_status_id != 1 || !$m || !$m->user)
            return redirect()->route('moderations')->withErrors(['forbidden' => __('Not available moderation')]);

        if ($moderation->moderationable_type == 'App\Models\User\Company' && (!$m->user->passport || $m->user->passport->moderation))
            return redirect()->route('moderations')->withErrors(['forbidden' => __('First you need to pass moderation by passport')]);

        if (!$m->moderation) {
            $files = [];
            $disk = 'public';

            switch ($moderation->moderationable_type) {
                case ('App\Models\User\Company'):
                    if (isset($moderation->data['logo']) && $m->logo) array_push($files, $m->logo);
                    if (isset($moderation->data['bg_logo']) && $m->bg_logo) array_push($files, $m->bg_logo);
                    if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($m->documents, 'path'));
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('App\Models\Ad\Hosting'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    if (isset($moderation->data['contract'])) array_push($files, $m->contract);
                    if (isset($moderation->data['territory']) && $m->territory) array_push($files, $m->territory);
                    if (isset($moderation->data['energy_supply']) && $m->energy_supply) array_push($files, $m->energy_supply);
                    break;
                case ('App\Models\Ad\Ad'):
                    if (isset($moderation->data['preview'])) array_push($files, $m->preview);
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('App\Models\Morph\Review'):
                    if (isset($moderation->data['document']) && $m->document) array_push($files, $m->document);
                    if (isset($moderation->data['image']) && $m->image) array_push($files, $m->image);
                    $disk = 'private';
                    if ($m && $m->reviewable)
                        $this->notify('New review', collect([$m->reviewable]), 'App\Models\Morph\Review', $m);
                    break;
                case ('App\Models\User\Office'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('App\Models\User\Passport'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                    $disk = 'private';
                    break;
                case ('App\Models\Blog\Guide'):
                    if (isset($moderation->data['preview'])) array_push($files, $m->preview);
                    break;
            }

            Storage::disk($disk)->delete($files);
        }

        $data = $moderation->data;
        if ($m->moderation) $data['moderation'] = 0;
        if ($moderation->moderationable_type == 'App\Models\Ad\Ad') {
            $m->unique_content = $isUniqueContent;

            if (isset($data['price'])) $this->notify(
                'Price change',
                $m->trackingUsers()->select(['users.id', 'users.tg_id'])->get(),
                'App\Models\Ad\Ad',
                $m
            );
        }

        $m->update($data);

        $moderation->moderation_status_id = 2;
        $moderation->user_id = $userId;
        $moderation->save();

        if ($moderation->moderationable_type != 'App\Models\Ad\Ad')
            $this->notify('Moderation completed', collect([$m->user]), 'App\Models\Morph\Moderation', $moderation);

        if ($moderation->moderationable_type == 'App\Models\Morph\Review' && $m->reviewable_type == 'App\Models\User\User')
            $this->notify('New review', collect([$m->reviewable]), 'App\Models\Morph\Review', $m);

        return redirect()->route('moderations');
    }

    public function declineModeration($comment, $moderation, $userId = null)
    {
        $userId = $userId ? $userId : \Auth::id();

        $m = $moderation->moderationable;

        if ($moderation->moderation_status_id != 1 || !$m || !$m->user) return redirect()->route('moderations');

        $files = [];
        $disk = 'public';

        switch ($moderation->moderationable_type) {
            case ('App\Models\User\Company'):
                if (isset($moderation->data['logo'])) array_push($files, $moderation->data['logo']);
                if (isset($moderation->data['bg_logo'])) array_push($files, $moderation->data['bg_logo']);
                if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($moderation->data['documents'], 'path'));
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('App\Models\Ad\Hosting'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                if (isset($moderation->data['contract'])) array_push($files, $moderation->data['contract']);
                if (isset($moderation->data['territory'])) array_push($files, $moderation->data['territory']);
                if (isset($moderation->data['energy_supply'])) array_push($files, $moderation->data['energy_supply']);
                break;
            case ('App\Models\Ad\Ad'):
                if (isset($moderation->data['preview'])) array_push($files, $moderation->data['preview']);
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('App\Models\Morph\Review'):
                if (isset($moderation->data['document'])) array_push($files, $moderation->data['document']);
                if (isset($moderation->data['image'])) array_push($files, $moderation->data['image']);
                $m->delete();
                $disk = 'private';
                break;
            case ('App\Models\User\Office'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('App\Models\User\Passport'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                $m->delete();
                $disk = 'private';
                break;
            case ('App\Models\Blog\Guide'):
                if (isset($moderation->data['preview'])) array_push($files, $moderation->data['preview']);
                break;
        }

        Storage::disk($disk)->delete($files);

        $moderation->moderation_status_id = 3;
        $moderation->comment = $comment;
        $moderation->user_id = $userId;
        $moderation->save();

        $this->notify('Moderation failed', collect([$m->user]), 'App\Models\Morph\Moderation', $moderation);

        return redirect()->route('moderations');
    }
}
