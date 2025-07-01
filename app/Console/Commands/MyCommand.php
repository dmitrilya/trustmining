<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\YandexGPT;

use App\Models\Algorithm;
use App\Models\AsicModel;

use Carbon\Carbon;

class MyCommand extends Command
{
    use YandexGPT;

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
        //$data = collect(file_get_contents('https://api.minerstat.com/v2/coins'));

        //$data->where('')

        dd($this->checkReviewWithPrompt('Все хорошо. Сотрудничество устраивает'));

        return Command::SUCCESS;
    }
}
