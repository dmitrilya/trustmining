<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Traits\NotificationTrait;
use App\Models\Database\Coin;
use App\Models\User\NotificationType;
use App\Models\User\User;

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
        $notificationTypeId = NotificationType::where('name', 'Difficulty changing')->value('id');
        $coinsToUsersMap = [];

        $users = User::whereHas('settings', function ($query) use ($notificationTypeId) {
            $query->where("notifications->{$notificationTypeId}->c", '!=', '[]');
        })->with('settings')->select(['id', 'tg_id', 'email', 'is_anchor'])->get();

        foreach ($users as $user) {
            $coinIds = $user->settings->notifications[$notificationTypeId]['c'];

            foreach ($coinIds as $coinId) {
                $coinsToUsersMap[$coinId][] = $user;
            }
        }

        if (empty($coinsToUsersMap)) {
            return Command::SUCCESS;
        }

        $coins = Coin::whereIn('id', array_keys($coinsToUsersMap))->select('id')->get()->keyBy('id');

        foreach ($coinsToUsersMap as $coinId => $groupUsers) {
            $coin = $coins->get($coinId);

            if (!$coin) {
                info("[Удаленная монета для отслеживания сложности у пользователей]\nмонета $coinId\nпользователи " . implode(', ', collect($groupUsers)->pluck('id')->toArray()));
                continue;
            }

            $this->notify('Difficulty changing', new Collection($groupUsers), 'coin', $coin);
        }

        return Command::SUCCESS;
    }
}
