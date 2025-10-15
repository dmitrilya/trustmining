<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\YandexGPT;
use App\Http\Traits\Telegram;
use App\Models\Algorithm;
use App\Models\AsicModel;
use App\Models\Coin;
use App\Models\User;

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
        User::first()->createToken('admin');

        return Command::SUCCESS;
    }
}
