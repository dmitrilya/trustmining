<?php

namespace App\Jobs;

use App\Services\Forum\ForumQuestionService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Http\Traits\ModerationTrait;

use App\Services\YandexGPTService;

class GetYandexGPTOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ModerationTrait;

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

        switch ($this->folder) {
            case 'moderation':
                $res = $res->alternatives[0]->status == 'ALTERNATIVE_STATUS_FINAL' ?
                    $this->service->parseJsonSafe($res->alternatives[0]->message->text, $this->fallbacks[0]) :
                    $this->fallbacks[1];

                if ($res['risk'] < 20) {
                    $this->model->moderation = false;
                    $this->model->save();

                    $this->acceptModeration(true, $this->model->moderations()->latest()->first());
                    break;
                }

                $reasons = implode('\n', $res['reasons']);
                Log::channel('moderation')->info("[Moderation failed] model={" . get_class($this->model) . "} model_id={$this->model->id} reasons:\n$reasons");
                $this->declineModeration($reasons, $this->model->moderations()->latest()->first(), 10000000);
                break;
            case 'hostings':
                if ($res->alternatives[0]->status != 'ALTERNATIVE_STATUS_FINAL') {
                    info('Contract Deficiencies error: ' . $res->alternatives[0]->status);
                    break;
                }
                $this->model->contract_deficiencies = json_decode(trim($res->alternatives[0]->message->text, "`\n\r "));
                $this->model->save();
                break;
            case 'forum-question':
                $res = $res->alternatives[0]->status == 'ALTERNATIVE_STATUS_FINAL' ?
                    $this->service->parseJsonSafe($res->alternatives[0]->message->text, $this->fallbacks[0]) :
                    $this->fallbacks[1];

                if (isset($res['risk'])) {
                    $reasons = implode('\n', $res['reasons']);
                    $this->declineModeration($reasons, $this->model->moderations()->latest()->first(), 10000000);
                    Log::channel('forum-question')->info("[Question classification risk] question={$this->model->id} reasons:\n$reasons");
                    break;
                }

                if (is_int($res['category'])) {
                    $this->model->forum_subcategory_id = $res['category'];
                    $this->model->moderation = false;
                } else Log::channel('forum-question')->info("[Question classification new category] question={$this->model->id} category={$res['category']}");

                $this->model->keywords = $res['keywords'];
                $this->model->save;

                $this->acceptModeration(true, $this->model->moderations()->latest()->first());

                (new ForumQuestionService())->findSimilarQuestions($this->model);

                break;
        }
    }
}
