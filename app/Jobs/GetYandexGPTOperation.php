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

    private $service;
    private $operationId;
    private $folder;
    private $modelId;
    private $fallbacks;
    private $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($operationId, string $folder,  array|null $fallbacks = null, int|null $modelId = null, array|null $model)
    {
        $this->service = new YandexGPTService();
        $this->operationId = $operationId;
        $this->folder = $folder;
        $this->modelId = $modelId;
        $this->fallbacks = $fallbacks;
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = $this->service->getOperation($this->operationId);

        if (!$res) return;

        switch ($this->folder) {
            case 'moderation':
                $res = $res->result->alternatives[0]->status == 'ALTERNATIVE_STATUS_FINAL' ?
                    $this->service->parseJsonSafe($res->result->alternatives[0]->message->text, $this->fallbacks[0]) : 
                    $this->fallbacks[1];
                break;
            case 'hostings':
                if ($res->result->alternatives[0]->status != 'ALTERNATIVE_STATUS_FINAL') {
                    info('Contract Deficiencies error: ' . $res->result->alternatives[0]->status);
                    break;
                }
                $hosting = Hosting::find($this->modelId);
                $hosting->contract_deficiencies = json_decode(str_replace('```', "'", $res->alternatives[0]->message->text));
                $hosting->save();
                break;
            case 'forum-question':
                $res = $res->result->alternatives[0]->status == 'ALTERNATIVE_STATUS_FINAL' ?
                    $this->service->parseJsonSafe($res->result->alternatives[0]->message->text, $this->fallbacks[0]) : 
                    $this->fallbacks[1];
                break;
        }
    }
}
