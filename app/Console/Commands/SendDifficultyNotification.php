<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Traits\NotificationTrait;
use App\Models\Metrics\DifficultySubscription;

class SendDifficultyNotification extends Command
{
    use NotificationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'difficulty-notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptions = DifficultySubscription::with(['coin', 'user'])->get();

        foreach ($subscriptions->groupBy('coin_id') as $group) {
            $coin = $group->first()->coin;
            $users = new Collection($group->pluck('user')->filter()->unique('id'));

            if ($users->isEmpty()) continue;

            $this->notify('Difficulty changing', $users, 'coin', $coin);
        }

        return Command::SUCCESS;
    }
}
