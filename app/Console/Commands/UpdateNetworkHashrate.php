<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Coin;

class UpdateNetworkHashrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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

        if ($coin->networkDifficulties()->latest()->first()->difficulty != $data->difficulty) $coin->networkDifficulties()->create([
            'difficulty' => $data->difficulty
        ]);

        return Command::SUCCESS;
    }
}
