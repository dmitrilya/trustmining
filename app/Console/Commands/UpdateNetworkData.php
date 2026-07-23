<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Exception;

use App\Http\Traits\NotificationTrait;
use App\Models\Database\Coin;
use App\Models\User\NotificationType;
use App\Models\User\User;

class UpdateNetworkData extends Command
{
    use NotificationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'network_data:update';

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
        $changed = new Collection();

        // BTC
        $coin = Coin::where('abbreviation', 'BTC')->with('latestNetworkDifficulty')->first();
        try {
            $data = json_decode(file_get_contents('https://api.blockchain.info/stats'));
            $coin->networkHashrates()->create(['hashrate' => $data->hash_rate * 1000000000]);
            $coin->networkDifficulties()->create(['difficulty' => $data->difficulty, 'need_blocks' => $data->nextretarget - $data->n_blocks_total]);

            Cache::put('calculator_difficulty_data', [
                'coin' => $coin->name,
                'difficulty' => number_format($data->difficulty),
                'article' => [
                    'id' => 10000001,
                    'slug' => 'sloznost-kriptoseti-rascet-i-vliianie',
                    'channel_slug' => 'trustmining'
                ]
            ]);

            if ($coin->latestNetworkDifficulty->need_blocks < $data->nextretarget - $data->n_blocks_total) $changed->push($coin);
        } catch (Exception $e) {
            Log::channel('integration-errors')->info("[blockchain.info] {$e->getMessage()}");
        }

        // LTC
        $coin = Coin::where('abbreviation', 'LTC')->with('latestNetworkDifficulty')->first();
        try {
            $dataRate = json_decode(file_get_contents('https://litecoinspace.org/api/v1/mining/hashrate/3d'));
            $dataDif = json_decode(file_get_contents('https://litecoinspace.org/api/v1/difficulty-adjustment'));
            $coin->networkHashrates()->create(['hashrate' => $dataRate->currentHashrate]);
            $coin->networkDifficulties()->create(['difficulty' => $dataRate->currentDifficulty, 'need_blocks' => $dataDif->remainingBlocks]);

            if ($coin->latestNetworkDifficulty->need_blocks < $dataDif->remainingBlocks) $changed->push($coin);
        } catch (Exception $e) {
            Log::channel('integration-errors')->info("[litecoinspace] {$e->getMessage()}");
        }

        $this->sendNotifications($changed);

        return Command::SUCCESS;
    }

    private function sendNotifications(Collection $changed)
    {
        if ($changed->isEmpty()) return;

        $notificationTypeId = NotificationType::where('name', 'Difficulty changing')->value('id');
        $changedCoinIds = $changed->pluck('id')->toArray();

        $users = User::whereHas('settings', function ($query) use ($notificationTypeId, $changedCoinIds) {
            $query->where(function ($q) use ($notificationTypeId, $changedCoinIds) {
                foreach ($changedCoinIds as $coinId) {
                    $q->orWhereJsonContains("notifications->{$notificationTypeId}->c", (int)$coinId);
                }
            });
        })->with('settings')->select(['id', 'tg_id', 'email', 'is_anchor'])->get();

        $coinsToUsersMap = [];

        foreach ($users as $user) {
            $userCoins = $user->settings->notifications[$notificationTypeId]['c'];
            $subscribedChangedCoins = array_intersect($userCoins, $changedCoinIds);

            foreach ($subscribedChangedCoins as $coinId) {
                $coinsToUsersMap[$coinId][] = $user;
            }
        }

        foreach ($changed as $changedCoin) {
            if (!isset($coinsToUsersMap[$changedCoin->id])) continue;

            $groupUsers = $coinsToUsersMap[$changedCoin->id];

            $this->notify('Difficulty changing', new Collection($groupUsers), 'coin', $changedCoin);
        }
    }
}
