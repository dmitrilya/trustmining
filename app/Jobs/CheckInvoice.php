<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Http\Traits\Tinkoff;

class CheckInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Tinkoff;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 20;

    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = $this->getInvoice($this->order->invoice_id);

        if ($response->status == 'EXECUTED') {
            $operations = $this->getOperations(['from' => $this->order->created_at->format('Y-m-d\Th:i:s\Z'), 'inns' => [$this->order->user->company->card['inn']]]);

            if (!count($operations)) $this->order->update(['status' => 'INVALID_PAYER']);
            else {
                $this->order->update(['status' => 'CONFIRMED']);
                $this->order->user->company->update(['moderation' => false]);
            }

            return;
        }

        switch ($this->attempts()) {
            case 1:
            case 2:
            case 3:
                $this->release(3600);
                break;
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
                $this->release(10800);
                break;
            case 11:
            case 12:
            case 13:
            case 14:
            case 15:
            case 16:
            case 17:
            case 18:
            case 19:
                $this->release(86400);
                break;
        }
    }
}
