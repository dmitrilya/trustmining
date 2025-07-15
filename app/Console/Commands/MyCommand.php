<?php

namespace App\Console\Commands;

use PhpOffice\PhpWord\IOFactory;

use Illuminate\Console\Command;

use App\Jobs\GetYandexGPTOperation;

use App\Http\Traits\YandexGPT;
use App\Http\Traits\Telegram;
use App\Models\Algorithm;
use App\Models\AsicModel;

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
        //$data = collect(file_get_contents('https://api.minerstat.com/v2/coins'));

        //$data->where('')

        $document = IOFactory::load(storage_path('app/public/Document.docx'));        
        $text = '';

        foreach ($document->getSections() as $s) {
            foreach ($s->getElements() as $e) {
                if (method_exists(get_class($e), 'getText')) {
                    $text .= $e->getText();
                } else {
                    $text .= "\n";
                }
            }
        }

        GetYandexGPTOperation::dispatch($this->checkDocument($text)->id)->delay(now()->addMinutes(1));

        return Command::SUCCESS;
    }
}
