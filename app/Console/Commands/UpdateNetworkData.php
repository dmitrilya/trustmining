<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Exception;

use App\Http\Traits\NotificationTrait;
use App\Models\Database\Coin;
use App\Models\Metrics\DifficultySubscription;

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
        $groupedSubscriptions = DifficultySubscription::with(['user', 'coin'])->get()->groupBy('coin_id');

        foreach ($changed as $changedCoin) {
            if (!$groupedSubscriptions->has($changedCoin->id)) continue;

            $coinSubscriptions = $groupedSubscriptions->get($changedCoin->id);

            $users = new Collection($coinSubscriptions->pluck('user')->filter()->unique('id'));

            if ($users->isEmpty()) continue;

            $this->notify('Difficulty changing', $users, 'coin', $changedCoin);
        }
    }
}
