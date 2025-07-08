<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use \App\Http\Traits\Telegram;

use \App\Models\Coin;

use Exception;

class SendTGNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Telegram;

    private $users;
    private $type;
    private $nt;
    private $n;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, $type, $notificationableType, $notificationable)
    {
        $this->users = $users->whereNotNull('tg_id')->where('tg_id', '!=', 0);
        $this->type = $type;
        $this->nt = $notificationableType;
        $this->n = $notificationable;
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping('tg-messaging'))->releaseAfter(3)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->users->splice(0, 30);

        switch ($this->nt) {
            case 'App\Models\Message':
                $text = $this->n->user->name . "\n\n" . $this->n->message;
                $keyboard = [[['text' => __('Contact'), 'url' => route('support', ['chat' => true])]]];
                break;

            case 'App\Models\Review':
                $rating = "";
                for ($i = 0; $i < $this->n->rating; $i++) $rating .= "⭐";
                $text = "$rating\n\n" . $this->n->review;
                $keyboard = [[['text' => __('Details'), 'url' => route('company.reviews', ['user' => $this->n->reviewable->url_name])]]];
                break;

            case 'App\Models\Moderation':
                $moderationTypes = ['App\Models\Company' => __('Company'), 'App\Models\Hosting' => __('Hosting'), 'App\Models\Ad' => __('Ad'), 'App\Models\Review' => __('Review'), 'App\Models\Office' => __('Office'), 'App\Models\Contact' => __('Contacts'), 'App\Models\Passport' => __('Passport')];
                $text = $moderationTypes[$this->n->moderationable_type];
                if ($this->n->comment) $text . "\n\n" . $this->n->comment;
                $keyboard = null;
                break;

            case 'App\Models\Ad':
                switch ($this->type) {
                    case 'Price change':
                        $lastModeration = $this->n->moderations()->whereNotNull('data->price')->latest()->limit(2)->get()[1];
                        $text = $this->n->asicVersion->asicModel->name . ' ' . $this->n->asicVersion->hashrate . $this->n->asicVersion->measurement . "\n" . $this->n->user->name . "\n\n" . $lastModeration->data['price'] . Coin::find($lastModeration->data['coin_id'])->abbreviation . " => " . $this->n->price . $this->n->coin->abbreviation;
                        $keyboard = [[
                            ['text' => __('Contact'), 'url' => route('chat.start', ['user' => $this->n->user->id, 'ad' => $this->n->id])],
                            ['text' => __('Details'), 'url' => route('ads.show', ['ad' => $this->n->id])],
                        ]];
                        break;
                }
                break;

            default:
                switch ($this->type) {
                    case 'Subscription renewal failed':
                        $text = __('Tariff reset to Base. Reactivate on the tariffs page');
                        $keyboard = [[['text' => __('Tariffs'), 'url' => route('tariffs')]]];
                        break;
                    case 'Top up your balance':
                        $text = __('In 7 days there will not be enough funds on the balance to extend the tariff');
                        $keyboard = [[['text' => __('Top up'), 'url' => route('order.create')]]];
                        break;
                }
                break;
        }

        try {
            $this->tgSendNotifications(
                $users->pluck('tg_id'),
                "<b>" . __('New notification') . "</b>\n\n<pre><code class='language-" . __($this->type) . "'>" . $text . "</code></pre>",
                $keyboard
            );
        } catch (Exception $e) {
            info('Exception - Job->SendTGNotifications: ' . $e->getMessage());
        }

        if ($this->users->count())
            SendTGNotifications::dispatch($this->users, $this->type, $this->nt, $this->n)->delay(now()->addSecond());
    }
}
