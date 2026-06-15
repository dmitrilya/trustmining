<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\SendTGNotifications;

use App\Http\Traits\Metrics\NetworkTrait;
use App\Http\Traits\NotificationTrait;
use App\Models\Metrics\DifficultySubscription;

use Carbon\Carbon;

class SendDifficultyNotification extends Command
{
    use NetworkTrait;

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
        $now = now();
        $types = ['Every 12 hours'];

        if ($now->hour === 10) {
            $types[] = 'Daily';

            if ($now->diffInDays(Carbon::parse('2026-01-01')) % 3 === 0) $types[] = 'Every 3 days';
        }

        $coins = DifficultySubscription::with(['user:id,tg_id', 'coin:id,name,target'])
            ->whereHas('difficultySubscriptionType', fn($q) => $q->whereIn('name', $types))->get()->groupBy('coin_id')->map(fn($group) => [
                'name' => $group[0]->coin->name,
                'difficultyData' => $this->difficultyData($group[0]->coin),
                'tgIds' => $group->pluck('user.tg_id')->filter()->unique()->values()
            ]);

        foreach ($coins as $coin) {
            $text = "{$coin['name']} difficulty alert\n\n";
            $text .= __('Current difficulty') . ': ' . number_format($coin['difficultyData']['lastDifficulty']['difficulty']) . "\n";
            $text .= __('Blocks before recalculation') . ': ' . $coin['difficultyData']['needBlocksTime'] . "\n";
            $text .= __('Next difficulty prediction') . ': ' . ($coin['difficultyData']['prediction'] >= 0 ? '+' : '') . $coin['difficultyData']['prediction'] . '%';

            SendTGNotifications::dispatch($coin['tgIds'], 'Difficulty alert', null, null, ['coin' => $coin['name'], 'text' => $text]);
        }

        return Command::SUCCESS;
    }
}
