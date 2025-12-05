<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Services\YandexGPTService;

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
    public function __construct($operationId, string $folder, array|null $fallbacks = null, $model)
    {
        $this->service = new YandexGPTService();
        $this->operationId = $operationId;
        $this->folder = $folder;
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
        info(json_encode($res));

        switch ($this->folder) {
            case 'moderation':
                $res = $res->alternatives[0]->status == 'ALTERNATIVE_STATUS_FINAL' ?
                    $this->service->parseJsonSafe($res->alternatives[0]->message->text, $this->fallbacks[0]) :
                    $this->fallbacks[1];
                break;
            case 'hostings':
                if ($res->alternatives[0]->status != 'ALTERNATIVE_STATUS_FINAL') {
                    info('Contract Deficiencies error: ' . $res->alternatives[0]->status);
                    break;
                }
                $this->model->contract_deficiencies = json_decode(str_replace('```', "'", $res->alternatives[0]->message->text));
                $this->model->save();
                break;
            case 'forum-question':
                $res = $res->alternatives[0]->status == 'ALTERNATIVE_STATUS_FINAL' ?
                    $this->service->parseJsonSafe($res->alternatives[0]->message->text, $this->fallbacks[0]) :
                    $this->fallbacks[1];
                info(json_encode($res));

                if (isset($res['risk'])) {
                    Log::channel('forum-question')->info("[Question classification risk] question={$this->model->id} reasons:\n" . implode('\n', $res['reasons']));
                    break;
                }

                if (is_int($res['category'])) {
                    $this->model->forum_subcategory_id = $res['category'];
                    $this->model->keywords = $res['keywords'];
                    $this->model->save;
                    break;
                }

                Log::channel('forum-question')->info("[Question classification new category] question={$this->model->id} category={$res['category']}");
                $this->model->keywords = $res['keywords'];
                $this->model->save;

                break;
        }
    }
}
