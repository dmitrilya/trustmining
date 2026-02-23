<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Traits\NotificationTrait;

use App\Models\Morph\Moderation;

trait ModerationTrait
{
    use NotificationTrait, FileTrait;

    public function getModerations($request)
    {
        $moderations = Moderation::where('moderation_status_id', 1)->select(['id', 'moderationable_type', 'moderationable_id', 'created_at'])
            ->with([
                'moderationable' => function ($morphTo) {
                    $morphTo->morphWith([
                        \App\Models\User\Company::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\Ad\Hosting::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\Ad\Ad::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\Morph\Review::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\User\Office::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\User\Passport::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\Forum\ForumQuestion::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\Forum\ForumAnswer::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],
                        \App\Models\Forum\ForumComment::class => ['user:id,name,tariff_id', 'user.company:user_id,logo'],

                        \App\Models\Insight\Content\Article::class => ['channel:id,user_id,name,logo', 'channel.user:id,tariff_id'],
                        \App\Models\Insight\Content\Post::class => ['channel:id,user_id,name,logo', 'channel.user:id,tariff_id'],
                    ]);
                }
            ]);

        if ($request->model)
            $moderations = $moderations->where('moderationable_type', 'like', '%' . $request->model);

        return $moderations;
    }

    public function acceptModeration($isUniqueContent, $moderation, $userId = null)
    {
        $userId = $userId ? $userId : Auth::id();

        $m = $moderation->moderationable;
        if ($moderation->moderation_status_id != 1 || !$m || !$m->user && !$m->channel)
            return redirect()->route('moderations')->withErrors(['forbidden' => __('Not available moderation')]);

        if (!$m->moderation) {
            $files = [];
            $disk = 'public';

            switch ($moderation->moderationable_type) {
                case ('company'):
                    if (isset($moderation->data['logo']) && $m->logo) array_push($files, $m->logo);
                    if (isset($moderation->data['bg_logo']) && $m->bg_logo) {
                        array_push($files, $m->bg_logo);
                        $files = array_merge($files, $this->getAdditionalFiles([$m->bg_logo], [188]));
                    }
                    if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($m->documents, 'path'));
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('hosting'):
                    if (isset($moderation->data['images'])) {
                        $files = array_merge($files, $m->images);
                        $files = array_merge($files, $this->getAdditionalFiles([$m->images[0]], [368, 188]));
                    }
                    if (isset($moderation->data['contract'])) array_push($files, $m->contract);
                    if (isset($moderation->data['territory']) && $m->territory) array_push($files, $m->territory);
                    if (isset($moderation->data['energy_supply']) && $m->energy_supply) array_push($files, $m->energy_supply);
                    break;
                case ('ad'):
                    if (isset($moderation->data['preview'])) {
                        array_push($files, $m->preview);
                        $files = array_merge($files, $this->getAdditionalFiles([$m->preview], [292, 188]));
                    }
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
                case ('review'):
                    if (isset($moderation->data['document']) && $m->document) array_push($files, $m->document);
                    if (isset($moderation->data['image']) && $m->image) array_push($files, $m->image);
                    $disk = 'private';
                    if ($m && $m->reviewable)
                        $this->notify('New review', collect([$m->reviewable]), 'review', $m);
                    break;
                case ('office'):
                    if (isset($moderation->data['images'])) {
                        $files = array_merge($files, $m->images);
                        $files = array_merge($files, $this->getAdditionalFiles($m->images, [212]));
                    }
                    break;
                case ('passport'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                    $disk = 'private';
                    break;
                case ('article'):
                case ('post'):
                case ('video'):
                    if (isset($moderation->data['preview'])) {
                        array_push($files, $m->preview);
                        $files = array_merge($files, $this->getAdditionalFiles([$m->preview], [400, 340, 284, 192]));
                    }
                    break;
                case ('forum-question'):
                case ('forum-answer'):
                case ('forum-comment'):
                    if (isset($moderation->data['images'])) $files = array_merge($files, $m->images);
                    break;
            }

            Storage::disk($disk)->delete($files);
        }

        $data = $moderation->data;
        if ($m->moderation) $data['moderation'] = 0;
        if ($moderation->moderationable_type == 'ad') {
            $m->unique_content = $isUniqueContent;

            if (isset($data['price'])) $this->notify(
                'Price change',
                $m->trackingUsers()->select(['users.id', 'users.tg_id'])->get(),
                'ad',
                $m
            );
        }

        $m->update($data);

        $moderation->moderation_status_id = 2;
        $moderation->user_id = $userId;
        $moderation->save();

        if ($moderation->moderationable_type != 'ad')
            $this->notify('Moderation completed', $m->user ? collect([$m->user]) : collect([$m->channel->user]), 'moderation', $moderation);

        if ($moderation->moderationable_type == 'review' && $m->reviewable_type == 'user' && isset($data['moderation']))
            $this->notify('New review', collect([$m->reviewable]), 'review', $m);
        elseif ($moderation->moderationable_type == 'forum-answer' && isset($data['moderation']) /* Не сработает на редактирование */)
            $this->notify('New forum answer', collect([$m->forumQuestion->user]), 'forum-answer', $m);
        elseif ($moderation->moderationable_type == 'forum-comment' && isset($data['moderation']) /* Не сработает на редактирование */)
            $this->notify('New forum comment', collect([$m->forumAnswer->user, $m->forumAnswer->forumQuestion->user]), 'forum-comment', $m);

        return redirect()->route('moderations');
    }

    public function declineModeration($comment, $moderation, $userId = null)
    {
        $userId = $userId ? $userId : Auth::id();

        $m = $moderation->moderationable;

        if ($moderation->moderation_status_id != 1 || !$m || !$m->user && !$m->channel) return redirect()->route('moderations');

        $files = [];
        $disk = 'public';

        switch ($moderation->moderationable_type) {
            case ('company'):
                if (isset($moderation->data['logo'])) array_push($files, $moderation->data['logo']);
                if (isset($moderation->data['bg_logo'])) {
                    array_push($files, $moderation->data['bg_logo']);
                    $files = array_merge($files, $this->getAdditionalFiles([$moderation->data['bg_logo']], [188]));
                }
                if (isset($moderation->data['documents'])) $files = array_merge($files, array_column($moderation->data['documents'], 'path'));
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('hosting'):
                if (isset($moderation->data['images'])) {
                    $files = array_merge($files, $moderation->data['images']);
                    $files = array_merge($files, $this->getAdditionalFiles([$moderation->data['images'][0]], [368, 188]));
                }
                if (isset($moderation->data['contract'])) array_push($files, $moderation->data['contract']);
                if (isset($moderation->data['territory'])) array_push($files, $moderation->data['territory']);
                if (isset($moderation->data['energy_supply'])) array_push($files, $moderation->data['energy_supply']);
                break;
            case ('ad'):
                if (isset($moderation->data['preview'])) {
                    array_push($files, $moderation->data['preview']);
                    $files = array_merge($files, $this->getAdditionalFiles([$moderation->data['preview']], [292, 188]));
                }
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
            case ('review'):
                if (isset($moderation->data['document'])) array_push($files, $moderation->data['document']);
                if (isset($moderation->data['image'])) array_push($files, $moderation->data['image']);
                $m->delete();
                $disk = 'private';
                break;
            case ('office'):
                if (isset($moderation->data['images'])) {
                    $files = array_merge($files, $moderation->data['images']);
                    $files = array_merge($files, $this->getAdditionalFiles($moderation->data['images'], [212]));
                }
                break;
            case ('passport'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                $m->delete();
                $disk = 'private';
                break;
            case ('article'):
            case ('post'):
            case ('video'):
                if (isset($moderation->data['preview'])) {
                    array_push($files, $moderation->data['preview']);
                    $files = array_merge($files, $this->getAdditionalFiles([$moderation->data['preview']], [400, 340, 284, 192]));
                }
                break;
            case ('forum-question'):
            case ('forum-answer'):
            case ('forum-comment'):
                if (isset($moderation->data['images'])) $files = array_merge($files, $moderation->data['images']);
                break;
        }

        Storage::disk($disk)->delete($files);

        $moderation->moderation_status_id = 3;
        $moderation->comment = $comment;
        $moderation->user_id = $userId;
        $moderation->save();

        $this->notify('Moderation failed', $m->user ? collect([$m->user]) : collect([$m->channel->user]), 'moderation', $moderation);

        return redirect()->route('moderations');
    }
}
