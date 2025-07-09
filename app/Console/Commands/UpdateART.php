<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Console\Command;

use App\Http\Traits\TrustFactor;

use App\Models\User;

use Carbon\Carbon;

class UpdateART extends Command
{
    use TrustFactor;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'art:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating average response time to messages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereHas('ads', fn(Builder $q) => $q->where('moderation', 'false')->where('hidden', 'false'))
            ->orWhereHas('hosting', fn(Builder $q) => $q->where('moderation', 'false'))->select(['id'])
            ->with([
                'chats:id',
                'chats.messages' =>
                fn(Builder $q) => $q->where('created_at', '>', Carbon::now()->subWeeks(2))->select(['chat_id', 'user_id', 'created_at'])
            ])->get();

        foreach ($users as $user) {
            $responseCount = 0;
            $responseTime = 0;

            if (!$user->chats->count()) continue;

            foreach ($user->chats as $chat) {
                $waitingResponse = false;

                foreach ($chat->messages as $message) {
                    if ($message->user_id != $user->id) {
                        if ($waitingResponse) continue;

                        $waitingResponse = true;
                        $waitingResponseFrom = $message->created_at;
                    } elseif ($waitingResponse) {
                        $waitingResponse = false;
                        $responseCount++;
                        $responseTime += $message->created_at->diffInMinutes($waitingResponseFrom);
                    }
                }
            }

            $user->art = $responseCount ? round($responseTime / $responseCount) : 0;
            $user->save();
        }

        return Command::SUCCESS;
    }
}
