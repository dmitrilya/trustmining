<?php

namespace App\Services\Insight;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use App\Http\Traits\FileTrait;

use App\Models\User\User;
use App\Models\Insight\Channel;
use App\Models\Insight\ContentModel;

class ChannelService
{
    use FileTrait;

    /**
     * Update the specified resource in storage.
     * 
     * @param User  $user
     * @param string  $name
     * @param string  $slug
     * @param string  $briefDescription
     * @param string  $description
     * @param UploadedFile  $logo
     * @param ?UploadedFile  $banner
     * @return Channel
     */
    public function store(User $user, string $name, string $slug, string $briefDescription, string $description, UploadedFile $logo, ?UploadedFile $banner): Channel
    {
        $channel = $user->channel()->create([
            'name' => $name,
            'slug' => $slug,
            'brief_description' => $briefDescription,
            'description' => $description,
            'logo' => '',
            'banner' => '',
        ]);

        $channel->logo = $this->saveFile($logo, 'insight/' . $slug, 'logo', $channel->id, null, 128);
        if ($banner) {
            $time = time();
            $channel->banner = $this->saveFile($banner, 'insight/' . $slug, 'banner', $channel->id, $time, [960, 360], 90);
            $this->saveFile($banner, 'insight/' . $slug, 'banner', $channel->id, $time, [416, 156], 90);
        }
        $channel->save();

        return $channel;
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param string  $name
     * @param string  $slug
     * @param string  $briefDescription
     * @param string  $description
     * @param ?UploadedFile  $logo
     * @param ?UploadedFile  $banner
     * @return Channel
     */
    public function update(Channel $channel, string $name, string $slug, string $briefDescription, string $description, ?UploadedFile $logo, ?UploadedFile $banner): Channel
    {
        $channel->name = $name;
        $channel->brief_description = $briefDescription;
        $channel->description = $description;
        if ($logo) {
            Storage::disk('public')->delete([$channel->logo]);
            $channel->logo = $this->saveFile($logo, 'insight/' . $channel->slug, 'logo', $channel->id, null, 128);
        }
        elseif ($channel->slug != $slug) $channel->logo = str_replace($channel->slug, $slug, $channel->logo);
        if ($banner) {
            Storage::disk('public')->delete(array_merge([$channel->banner], $this->getAdditionalFiles([[$channel->banner]], [416])));
            $time = time();
            $channel->banner = $this->saveFile($banner, 'insight/' . $slug, 'banner', $channel->id, $time, [960, 360], 90);
            $this->saveFile($banner, 'insight/' . $slug, 'banner', $channel->id, $time, [416, 156], 90);
        }
        elseif ($channel->banner && $channel->slug != $slug) $channel->banner = str_replace($channel->slug, $slug, $channel->banner);
        if ($channel->slug != $slug) {
            foreach ($channel->getContent() as $content) {
                $content->preview = str_replace($channel->slug, $slug, $content->preview);
                $content->save();
            }
            Storage::disk('public')->move('insight/' . $channel->slug, 'insight/' . $slug);
            $channel->slug = $slug;
        }
        $channel->save();

        return $channel;
    }

    /**
     * Destroy the specified resource in storage.
     * 
     * @param Channel  $channel
     * @return void
     */
    public function destroy(Channel $channel): void
    {
        Storage::disk('public')->delete([$channel->logo, $channel->banner]);

        $channel->delete();
    }

    /**
     * Get top channels by views of any content over the last 7 days
     */
    public function getTopChannels()
    {
        return Cache::remember(
            'top_channels_weekly',
            now()->endOfDay(),
            fn() => Channel::query()
                ->select('channels.*', DB::raw('count(views.id) as weekly_views'))
                ->joinSub(ContentModel::unionAllQuery(), 'content_map', 'channels.id', '=', 'content_map.channel_id')
                ->join('views', function ($join) {
                    $join->on('views.viewable_id', '=', 'content_map.id')
                        ->on('views.viewable_type', '=', 'content_map.type');
                })->where('views.created_at', '>=', now()->subDays(7))
                ->groupBy('channels.id')->orderByDesc('weekly_views')->limit(5)->withCount('activeSubscribers')->get()
        );
    }

    /**
     * Toggle subscription fot unauthenticated
     * 
     * @param User  $user
     * @param Channel  $channel
     * @param string  $backUrl
     * @return Response
     */
    public function toggleSubscriptionGet(User $user, Channel $channel, string $backUrl)
    {
        $backUrl = $backUrl ?? route('insight.channel.show', ['channel' => $channel->slug]);

        if ($user->id == $channel->user_id)
            return redirect()->to($backUrl)
                ->withErrors(['forbidden' => __('Not available')]);

        if (!$user->activeSubscriptions()->wherePivot('channel_id', $channel->id)->exists())
            $user->subscriptions()->attach($channel->id);

        return redirect()->to($backUrl);
    }

    /**
     * Toggle subscription
     * 
     * @param User  $user
     * @param Channel  $channel
     * @return Response
     */
    public function toggleSubscription(User $user, Channel $channel)
    {
        if ($user->id == $channel->user_id) return response()->json(['success' => false, 'error' => __('Not available')]);

        $activeSubscription = $user->activeSubscriptions()->wherePivot('channel_id', $channel->id)->first();

        if ($activeSubscription) {
            $user->activeSubscriptions()->updateExistingPivot($channel->id, ['unsubscribed_at' => now()]);
            return response()->json(['success' => true, 'text' => __('Subscribe')]);
        } else {
            $user->subscriptions()->attach($channel->id);
            return response()->json(['success' => true, 'text' => __('Unsubscribe')]);
        }
    }
}
