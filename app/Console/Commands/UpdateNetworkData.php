<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Models\Coin;
use App\Models\NetworkHashrate;

class UpdateNetworkData extends Command
{
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
        // BTC
        $coin = Coin::where('abbreviation', 'BTC')->first();
        $data = json_decode(file_get_contents('https://api.blockchain.info/stats'));
        $coin->networkHashrates()->create(['hashrate' => $data->hash_rate]);
        $coin->networkDifficulties()->create(['difficulty' => $data->difficulty, 'need_blocks' => $data->nextretarget - $data->n_blocks_total]);

        return Command::SUCCESS;
    }
}
