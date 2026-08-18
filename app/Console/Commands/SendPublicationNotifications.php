<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\NotificationTrait;
use App\Models\Insight\ContentModel;

class SendPublicationNotifications extends Command
{
    use NotificationTrait;

    protected $signature = 'publications:notify';

    protected $description = 'Проверяет наступившие публикации за текущую минуту и рассылает уведомления подписчикам';

    public function handle(): void
    {
        $startOfMinute = now()->startOfMinute();
        $endOfMinute = now()->endOfMinute();

        foreach (ContentModel::getInheritors() as $type => $contentClass) {
            $contentItems = $contentClass::where('moderation', false)->whereBetween('published_at', [$startOfMinute, $endOfMinute])
                ->with('channel.activeSubscribers')->get();

            foreach ($contentItems as $content) {
                $this->notify('New publication', $content->channel->activeSubscribers, $type, $content);
            }
        }
    }
}
