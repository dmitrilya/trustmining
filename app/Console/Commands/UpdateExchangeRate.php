<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchangerates:update';

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
        $data = json_decode(file_get_contents('https://www.binance.com/bapi/asset/v2/public/asset-service/product/get-products'));

        if ($data->code == '000000') $data = collect($data->data)->where('q', 'USDT');

        return Command::SUCCESS;
    }
}
