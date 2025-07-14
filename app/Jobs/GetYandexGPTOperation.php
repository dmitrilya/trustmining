<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Http\Traits\YandexGPT;

class GetYandexGPTOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, YandexGPT;

    public $operationId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($operationId)
    {
        $this->operationId = $operationId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $operationResponse = $this->getOperation($this->operationId);

        if (!$operationResponse) return;

        info($operationResponse);
    }
}
