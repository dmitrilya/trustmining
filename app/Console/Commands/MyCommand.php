<?php

namespace App\Console\Commands;

use App\Models\Algorithm;
use App\Models\AsicModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MyCommand extends Command
{
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
        $data = collect(file_get_contents('https://api.minerstat.com/v2/coins'));

        //$data->where('')

        return Command::SUCCESS;
    }
}
