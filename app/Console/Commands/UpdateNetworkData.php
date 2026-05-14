<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

use App\Http\Traits\Metrics\NetworkTrait;
use App\Jobs\SendTGNotifications;
use App\Models\Database\Coin;
use App\Models\Metrics\DifficultySubscription;

class UpdateNetworkData extends Command
{
    use NetworkTrait;

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
        $changed = [];

        // BTC
        $coin = Coin::where('abbreviation', 'BTC')->with('latestNetworkDifficulty')->first();
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

        if ($coin->latestNetworkDifficulty->need_blocks < $data->nextretarget - $data->n_blocks_total)
            array_push($changed, ['id' => $coin->id, 'pd' => $coin->latestNetworkDifficulty->difficulty, 'cd' => $data->difficulty]);

        // LTC
        $coin = Coin::where('abbreviation', 'LTC')->with('latestNetworkDifficulty')->first();
        try {
            $dataRate = json_decode(file_get_contents('https://litecoinspace.org/api/v1/mining/hashrate/3d'));
            $dataDif = json_decode(file_get_contents('https://litecoinspace.org/api/v1/difficulty-adjustment'));
            $coin->networkHashrates()->create(['hashrate' => $dataRate->currentHashrate]);
            $coin->networkDifficulties()->create(['difficulty' => $dataRate->currentDifficulty, 'need_blocks' => $dataDif->remainingBlocks]);

            if ($coin->latestNetworkDifficulty->need_blocks < $dataDif->remainingBlocks)
                array_push($changed, ['id' => $coin->id, 'pd' => $coin->latestNetworkDifficulty->difficulty, 'cd' => $dataRate->currentDifficulty]);
        } catch (Exception $e) {
            Log::channel('integration-errors')->info("[litecoinspace] {$e->getMessage()}");
        }

        if (count($changed)) $this->sendNotifications($changed);

        return Command::SUCCESS;
    }

    private function sendNotifications(array $changed)
    {
        $coins = DifficultySubscription::with(['user:id,tg_id', 'coin:id,name'])
            ->whereHas('difficultySubscriptionType', fn($q) => $q->where('name', 'On difficulty change'))->get()->groupBy('coin_id')->map(fn($group) => [
                'name' => $group[0]->coin->name,
                'tgIds' => $group->pluck('user.tg_id')->filter()->unique()->values()
            ]);

        foreach (
            collect($changed)->filter(function ($item) use ($coins) {
                return $coins->has($item['id']);
            })->values()->all() as $changedCoin
        ) {
            $coin = $coins[$changedCoin['id']];
            $text = "{$coin['name']} difficulty alert\n\n";
            $text .= __('Previous difficulty') . ': ' . number_format($changedCoin['pd']) . "\n";
            $text .= __('Current difficulty') . ': ' . number_format($changedCoin['cd']) . "\n";
            $text .= ($changedCoin['cd'] >= $changedCoin['pd'] ? '+' : '-') . round(abs($changedCoin['cd'] - $changedCoin['pd']) / $changedCoin['pd'] * 100, 2) . '%';

            SendTGNotifications::dispatch($coin['tgIds'], 'Difficulty alert', null, null, ['coin' => $coin['name'], 'text' => $text]);
        }
    }
}
