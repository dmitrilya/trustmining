<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Database\Algorithm;
use App\Models\Database\Coin;
use Carbon\Carbon;

class UpdateCoinProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinprofit:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $coinIds = [
        22 => 'FB',
        10 => 'DOGE',
        21 => 'BEL',
        23 => 'LKY',
        24 => 'PEP',
        25 => 'JKC'
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mes = ['h', 'kh', 'Mh', 'Gh', 'Th', 'Ph', 'Eh', 'Zh'];
        $algos = Algorithm::all();

        collect(json_decode(file_get_contents('https://www.antpool.com/auth/v3/index/poolcoins'))->data->items)->whereNotIn('coinType', ['FB'])
            ->each(function ($coin) use ($mes, $algos) {
                if ($coin->algorithm == 'SHA256d') $coin->algorithm = 'SHA-256';
                elseif ($coin->algorithm == 'Blake2B+SHA3') $coin->algorithm = 'Handshake';
                elseif ($coin->algorithm == 'Blake2S') $coin->algorithm = 'Blake (2s-Kadena)';
                elseif ($coin->algorithm == 'SCRYPT') $coin->algorithm = 'Scrypt';

                $algorithm = $algos->where('name', $coin->algorithm)->first();
                if (!$algorithm) return Log::channel('unknownalgo')->info("coin={$coin->coinType} algorithm={$coin->algorithm}");

                $profit = $coin->blockReward * 86400 / $coin->coinCoefficient / $coin->networkDiff * pow(1000, array_search($algorithm->measurement, $mes));
                Coin::where('abbreviation', $coin->coinType)->update(['profit' => $profit, 'difficulty' => $coin->networkDiff, 'reward_block' => $coin->blockIncentive]);

                if (!$coin->mergeMiningInfos) return;
                foreach ($coin->mergeMiningInfos as $mergeCoin) {
                    Coin::where('abbreviation', $mergeCoin->coinType)->update(['profit' => $profit * $mergeCoin->mergeRate]);
                }
            });

        $i = 1;
        foreach (
            Coin::where('paymentable', false)->where('updated_at', '<', Carbon::now()->subMinutes(2))
                ->whereNotNull('profit')->pluck('abbreviation')->chunk(10) as $coins
        ) {
            collect(json_decode(file_get_contents('https://api.minerstat.com/v2/coins?key=' .
                config('services.minerstat.key' . $i) . '&list=' . $coins->implode(','))))
                ->each(function ($coin) use ($mes, $algos) {
                    if ($coin->coin == 'GRIN') return;

                    $coinData = [];
                    if ($coin->algorithm == 'Radiant') $coin->algorithm = 'SHA512256d';
                    if ($coin->algorithm == 'NexaHash') $coin->algorithm = 'NexaPow';

                    $algorithm = $algos->where('name', $coin->algorithm)->first();
                    if (!$algorithm) return;

                    if ($coin->reward !== -1) $coinData['profit'] = $coin->reward * 24 * pow(1000, array_search($algorithm->measurement, $mes));
                    if ($coin->reward_block !== -1) $coinData['reward_block'] = $coin->reward_block;

                    if (count($coinData)) Coin::where('abbreviation', $coin->coin)->update($coinData);
                });

            $i++;
        }

        return Command::SUCCESS;
    }
}
