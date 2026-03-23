<?php

namespace App\Console\Commands;

use App\Models\Database\Coin;
use App\Models\Forum\ForumSubcategory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        foreach (Coin::all() as $coin) {
            if ($coin->rate) $coin->coinRates()->create(['rate' => $coin->rate]);
        }

        return Command::SUCCESS;
    }
}
