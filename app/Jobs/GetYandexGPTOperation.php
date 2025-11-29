<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Services\YandexGPTService;

use App\Models\Ad\Hosting;

class GetYandexGPTOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $operationId;
    public $folder;
    public $modelId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($operationId, $folder, $modelId)
    {
        $this->operationId = $operationId;
        $this->folder = $folder;
        $this->modelId = $modelId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $operationResponse = (new YandexGPTService())->getOperation($this->operationId);

        if (!$operationResponse) return;

        switch ($this->folder) {
            case 'hostings':
                $hosting = Hosting::find($this->modelId);
                $hosting->contract_deficiencies = json_decode(str_replace('```', "'", $operationResponse->alternatives[0]->message->text));
                $hosting->save();
                break;
        }
    }
}
