<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use App\Services\Chat\ArtCalculator;

use App\Models\User;

use Carbon\Carbon;

class UpdateART extends Command
{
    protected $signature = 'art:update';
    protected $description = 'Updating average response time to messages';

    public function handle()
    {
        $twoWeeksAgo = Carbon::now()->subWeeks(2);

        $users = User::whereHas('ads', fn($q) => $q->where('moderation', 'false')->where('hidden', 'false'))
            ->orWhereHas('hosting', fn($q) => $q->where('moderation', 'false'))
            ->select(['id'])->with([
                'chats:id',
                'chats.messages' => fn($q) => $q->where('created_at', '>', $twoWeeksAgo)->orderBy('created_at')
                    ->select(['chat_id', 'user_id', 'created_at'])
            ])->get();

        $service = new ArtCalculator;

        foreach ($users as $user) {
            $old = $user->art;

            $user->art = $service->calculateForUser($user);
            $user->save();

            Log::channel('art')->info('ART updated', [
                'user_id'  => $user->id,
                'old'      => $old,
                'new'      => $user->art,
                'changed'  => $old !== $user->art,
                'chats'    => $user->chats->count(),
            ]);
        }

        return Command::SUCCESS;
    }
}
