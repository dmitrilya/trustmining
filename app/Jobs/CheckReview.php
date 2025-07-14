<?php

namespace App\Jobs;

use App\Http\Traits\ModerationTrait;
use App\Http\Traits\YandexGPT;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, YandexGPT, ModerationTrait;
    
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;


    public $review;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($review)
    {
        $this->review = $review;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $lastModeration = $this->review->moderations()->latest()->first();
            $result = $this->checkReviewWithPrompt($lastModeration);

            switch ($result['label']) {
                case 'Фальшивый':
                    $this->review->fake = true;
                    $this->review->save();

                    $this->acceptModeration(null, $lastModeration, 10000000);
                    break;
                case 'Настоящий':
                    $this->acceptModeration(null, $lastModeration, 10000000);
                    break;
                case 'Оскорбительный':
                    $this->declineModeration(__('Please try to express your emotions without directly insulting'), $lastModeration, 10000000);
                    break;
            }
        } catch (Exception $e) {
            info('Job\CheckReview '. $this->review->id . ': ' . $e->getMessage());
            if ($this->attempts() < 3) {
                $this->release(3);
            }
        }
    }
}
