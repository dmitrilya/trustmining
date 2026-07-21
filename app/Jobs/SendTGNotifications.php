<?php

namespace App\Jobs;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use \App\Http\Traits\Telegram;

use \App\Models\Database\Coin;

use Exception;

class SendTGNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Telegram;

    private Collection $tgIds;
    private string $type;
    private ?string $nt;
    private $n;
    private ?array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $tgIds, string $type, ?string $notificationableType, $notificationable, ?array $data = null)
    {
        $this->tgIds = $tgIds;
        $this->type = $type;
        $this->nt = $notificationableType;
        $this->n = $notificationable;
        $this->data = $data;
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
        $tgIds = $this->tgIds->splice(0, 30);

        switch ($this->nt) {
            case 'message':
                $text = $this->n->user->name . "\n\n" . $this->n->message;
                $keyboard = [[[
                    'text' => __('Contact'),
                    'url' => $this->n->user->role->name == 'support' ? route('support', ['chat' => true]) :
                        route('chat', ['chat' => $this->n->chat_id])
                ]]];
                break;

            case 'review':
                $rating = "";
                for ($i = 0; $i < $this->n->rating; $i++) $rating .= "⭐";
                $text = "$rating\n\n" . $this->n->review;
                $keyboard = [[['text' => __('Details'), 'url' => route('company.reviews', ['user' => $this->n->reviewable->slug])]]];
                break;

            case 'moderation':
                $text = __('types.' . $this->n->moderationable_type);
                if ($this->n->comment) $text .= "\n\n" . $this->n->comment;
                $keyboard = null;
                break;

            case 'ad':
                switch ($this->type) {
                    case 'Price change':
                        $lastModeration = $this->n->moderations()->whereNotNull('data->price')->latest()->limit(2)->get()[1];
                        $price = $this->n->price != 0 ? $this->n->price : __('Price on request');
                        $text = $this->n->asicVersion->asicModel->name . ' ' . $this->n->asicVersion->hashrate . $this->n->asicVersion->measurement . "\n" . $this->n->user->name . "\n\n" . $lastModeration->data['price'] . (isset($lastModeration->data['coin_id']) ? Coin::find($lastModeration->data['coin_id'])->abbreviation : $this->n->coin->abbreviation) . " => " . $price . $this->n->coin->abbreviation;
                        $keyboard = [[
                            ['text' => __('Contact'), 'url' => route('chat.start', ['user' => $this->n->user->id, 'ad' => $this->n->id])],
                            ['text' => __('Details'), 'url' => route('ads.show', ['adCategory' => $this->n->adCategory->name, 'ad' => $this->n->id])],
                        ]];
                        break;
                    default:
                        $text = __('New notification');
                        $keyboard = null;
                }
                break;

            case 'coin':
                switch ($this->type) {
                    case 'Difficulty changing':
                        $difficulties = $this->n->networkDifficulties()->latest()->take(2)->get();
                        $pd = $difficulties[1]->difficulty;
                        $cd = $difficulties[0]->difficulty;

                        if ($pd != $cd) {
                            $text = "{$this->n->name}\n\n";
                            $text .= __('Previous difficulty') . ': ' . number_format($pd) . "\n";
                            $text .= __('Current difficulty') . ': ' . number_format($cd) . "\n";
                            $text .= ($cd >= $pd ? '+' : '-') . round(abs($cd - $pd) / $pd * 100, 2) . '%';
                        } else {
                            $difficultyData = $this->n->difficultyData();

                            $text = "{$this->n->name}\n\n";
                            $text .= __('Current difficulty') . ': ' . number_format($difficultyData['lastDifficulty']['difficulty']) . "\n";
                            $text .= __('Blocks before recalculation') . ': ' . $difficultyData['needBlocksTime'] . "\n";
                            $text .= __('Next difficulty prediction') . ': ' . ($difficultyData['prediction'] >= 0 ? '+' : '') . $difficultyData['prediction'] . '%';
                        }

                        $keyboard = [[['text' => __('View on the website'), 'url' => route('metrics.network.difficulty', ['coin' => strtolower($this->n->name)])]]];
                        break;
                    default:
                        $text = __('New notification');
                        $keyboard = null;
                }
                break;

            default:
                switch ($this->type) {
                    case 'Subscription renewal failed':
                        $text = __('Tariff reset to Base. Reactivate on the tariffs page');
                        $keyboard = [[['text' => __('Tariffs'), 'url' => route('tariffs')]]];
                        break;
                    case 'Top up your balance (7 days)':
                        $text = __('In 7 days there will not be enough funds on the balance to extend the tariff');
                        $keyboard = [[['text' => __('Top up'), 'url' => route('order.create')]]];
                        break;
                    case 'Top up your balance (3 days)':
                        $text = __('In 3 days there will not be enough funds on the balance to extend the tariff');
                        $keyboard = [[['text' => __('Top up'), 'url' => route('order.create')]]];
                        break;
                    case 'Top up your balance (1 day)':
                        $text = __('Tomorrow there will not be enough funds on the balance to extend the tariff');
                        $keyboard = [[['text' => __('Top up'), 'url' => route('order.create')]]];
                        break;
                    case 'Similar questions':
                        $text = __('Before publishing, please review questions similar to yours');
                        $keyboard = [[['text' => __('Details'), 'url' => route('forum.question.mine')]]];
                        break;
                    case 'New moderation':
                        $text = __('New moderation');
                        $keyboard = null;
                        break;
                    case 'New forum answer':
                        $text = $this->n->forumQuestion->theme . "\n\n" . trim(strip_tags(str_replace(['</div>', '<br>', '<br/>', '&nbsp;'], ["\n", "\n", "\n", " "], $this->n->text)));
                        $keyboard = [[['text' => __('Details'), 'url' => route('forum.question.show', [
                            'forumCategory' => $this->n->forumQuestion->forumSubcategory->forumCategory->slug,
                            'forumSubcategory' => $this->n->forumQuestion->forumSubcategory->slug,
                            'forumQuestion' => $this->n->forumQuestion->id . '-' . Str::slug($this->n->forumQuestion->theme),
                            'answer' => $this->n->id
                        ])]]];
                        break;
                    case 'New forum comment':
                        $text = $this->n->forumAnswer->forumQuestion->theme . "\n\n" . trim(strip_tags(str_replace(['</div>', '<br>', '<br/>', '&nbsp;'], ["\n", "\n", "\n", " "], $this->n->text)));
                        $keyboard = [[['text' => __('Details'), 'url' => route('forum.question.show', [
                            'forumCategory' => $this->n->forumAnswer->forumQuestion->forumSubcategory->forumCategory->slug,
                            'forumSubcategory' => $this->n->forumAnswer->forumQuestion->forumSubcategory->slug,
                            'forumQuestion' => $this->n->forumAnswer->forumQuestion->id . '-' . Str::slug($this->n->forumAnswer->forumQuestion->theme),
                            'answer' => $this->n->forum_answer_id
                        ])]]];
                        break;
                    case 'New publication':
                        $text = $this->n->channel->name . "\n\n";

                        switch ($this->nt) {
                            case 'article':
                                $text .= $this->n->title;
                                $keyboard = [[['text' => __('Read'), 'url' => route('insight.article.show', ['channel' => $this->n->channel->slug, 'article' => $this->n->id . '-' . Str::slug($this->n->title)])]]];
                            case 'post':
                                $text .= $this->n->content;
                                $keyboard = [[['text' => __('Read'), 'url' => route('insight.post.show', ['channel' => $this->n->channel->slug, 'post' => $this->n->id])]]];
                            case 'video':
                                $text .= $this->n->title;
                                $keyboard = [[['text' => __('Watch'), 'url' => route('insight.video.show', ['channel' => $this->n->channel->slug, 'video' => $this->n->id . '-' . Str::slug($this->n->title)])]]];
                            default:
                                $text = __('New notification');
                                $keyboard = null;
                        }
                        break;
                    default:
                        $text = __('New notification');
                        $keyboard = null;
                }
                break;
        }

        try {
            $this->tgSendNotifications(
                $tgIds,
                "<b>" . __('New notification') . "</b>\n\n<pre><code class='language-" . __($this->type) . "'>" . $text . "</code></pre>",
                $keyboard
            );
        } catch (Exception $e) {
            info('Exception - Job->SendTGNotifications: ' . $e->getMessage());
        }

        if ($this->tgIds->count())
            SendTGNotifications::dispatch($this->tgIds, $this->type, $this->nt, $this->n)->delay(now()->addSecond());
    }
}
