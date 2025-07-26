<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\YandexGPT;
use App\Http\Traits\Telegram;
use App\Models\Algorithm;
use App\Models\AsicModel;
use App\Models\Coin;

use Carbon\Carbon;

class MyCommand extends Command
{
    use YandexGPT, Telegram;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycommand:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $algo = Algorithm::pluck('name')->implode(',');
        $data = collect(json_decode(file_get_contents('https://api.minerstat.com/v2/coins?algo=' . $algo)));
        dd($data);
        //$data->where('')

        return Command::SUCCESS;
    }
}
