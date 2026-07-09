<?php

namespace App\Jobs;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pusher\PushNotifications\PushNotifications;

use App\Http\Traits\Metrics\NetworkTrait;
use App\Models\Database\Coin;
use Exception;

class SendWebNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, NetworkTrait;

    private Collection $userIds;
    private string $type;
    private ?string $nt;
    private $n;
    private ?array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $userIds, string $type, ?string $notificationableType, $notificationable, ?array $data = null)
    {
        $this->userIds = $userIds->map(fn($id) => (string)$id)->unique();
        $this->type = $type;
        $this->nt = $notificationableType;
        $this->n = $notificationable;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chunkIds = $this->userIds->splice(0, 1000);

        $title = __($this->type) ?? __('New notification');
        $body = '';
        $link = url('/');
        $icon = url('/img/logo-circle.webp');

        switch ($this->nt) {
            case 'message':
                $title = $this->n->user->name;
                $body = $this->n->message;
                $link = $this->n->user->role->name == 'support'
                    ? route('support', ['chat' => true])
                    : route('chat', ['chat' => $this->n->chat_id]);
                if ($this->n->user->role->name != 'support' && $this->n->user->company?->logo) $icon = url(Storage::url($this->n->user->company->logo));
                break;

            case 'review':
                $rating = "";
                for ($i = 0; $i < $this->n->rating; $i++) $rating .= "⭐";
                $title = $rating . ' ' . __('New review');
                $body = $this->n->review;
                $link = route('company.reviews', ['user' => $this->n->reviewable->slug]);
                break;

            case 'moderation':
                $body = __('types.' . $this->n->moderationable_type);
                if ($this->n->comment) $body .= "\n\n" . $this->n->comment;
                break;

            case 'ad':
                switch ($this->type) {
                    case 'Price change':
                        $lastModeration = $this->n->moderations()->whereNotNull('data->price')->latest()->limit(2)->get()[1];
                        $price = $this->n->price != 0 ? $this->n->price : __('Price on request');
                        $preview = explode('.', $this->n->preview);
                        $previewxs = preg_replace('/_[0-9]+$/', '', $preview[0]) . '_224' . '.' . $preview[1];

                        $title = $this->n->asicVersion->asicModel->name;
                        $body = $lastModeration->data['price'] . (isset($lastModeration->data['coin_id']) ? Coin::find($lastModeration->data['coin_id'])->abbreviation : $this->n->coin->abbreviation) . " => " . $price . $this->n->coin->abbreviation;
                        $link = route('ads.show', ['adCategory' => $this->n->adCategory->name, 'ad' => $this->n->id]);
                        $icon = url(Storage::url($previewxs));
                        break;
                    default:
                        $title = __('New notification');
                }
                break;

            case 'coin':
                switch ($this->type) {
                    case 'Difficulty changing':
                        $difficulties = $this->n->networkDifficulties()->latest()->take(2)->get();
                        $pd = $difficulties[1]->difficulty;
                        $cd = $difficulties[0]->difficulty;

                        $title = "{$this->n->name} — " . __('Difficulty changing');

                        if ($pd != $cd) {
                            $body = __('Previous difficulty') . ': ' . number_format($pd) . "\n";
                            $body .= __('Current difficulty') . ': ' . number_format($cd) . "\n";
                            $body .= ($cd >= $pd ? '+' : '-') . round(abs($cd - $pd) / $pd * 100, 2) . '%';
                        } else {
                            $difficultyData = $this->difficultyData($this->n);

                            $body = __('Current difficulty') . ': ' . number_format($difficultyData['lastDifficulty']['difficulty']) . "\n";
                            $body .= __('Blocks before recalculation') . ': ' . $difficultyData['needBlocksTime'] . "\n";
                            $body .= __('Next difficulty prediction') . ': ' . ($difficultyData['prediction'] >= 0 ? '+' : '') . $difficultyData['prediction'] . '%';
                        }

                        $link = route('metrics.network.difficulty', ['coin' => strtolower($this->n->name)]);
                        break;
                    default:
                        $body = __('New notification');
                }
                break;

            default:
                switch ($this->type) {
                    case 'Subscription renewal failed':
                        $body = __('Tariff reset to Base. Reactivate on the tariffs page');
                        $link = route('tariffs');
                        break;
                    case 'Top up your balance (7 days)':
                        $body = __('In 7 days there will not be enough funds on the balance to extend the tariff');
                        $link = route('order.create');
                        break;
                    case 'Top up your balance (3 days)':
                        $body = __('In 3 days there will not be enough funds on the balance to extend the tariff');
                        $link = route('order.create');
                        break;
                    case 'Top up your balance (1 day)':
                        $body = __('Tomorrow there will not be enough funds on the balance to extend the tariff');
                        $link = route('order.create');
                        break;
                    case 'Similar questions':
                        $body = __('Before publishing, please review questions similar to yours');
                        $link = route('forum.question.mine');
                        break;
                    case 'New forum answer':
                        $title = $this->n->forumQuestion->theme;
                        $body = trim(strip_tags(str_replace(['</div>', '<br>', '<br/>', '&nbsp;'], ["\n", "\n", "\n", " "], $this->n->text)));
                        $link = route('forum.question.show', [
                            'forumCategory' => $this->n->forumQuestion->forumSubcategory->forumCategory->slug,
                            'forumSubcategory' => $this->n->forumQuestion->forumSubcategory->slug,
                            'forumQuestion' => $this->n->forumQuestion->id . '-' . Str::slug($this->n->forumQuestion->theme),
                            'answer' => $this->n->id
                        ]);
                        break;
                    case 'New forum comment':
                        $title = $this->n->forumAnswer->forumQuestion->theme;
                        $body = trim(strip_tags(str_replace(['</div>', '<br>', '<br/>', '&nbsp;'], ["\n", "\n", "\n", " "], $this->n->text)));
                        $link = route('forum.question.show', [
                            'forumCategory' => $this->n->forumAnswer->forumQuestion->forumSubcategory->forumCategory->slug,
                            'forumSubcategory' => $this->n->forumAnswer->forumQuestion->slug,
                            'forumQuestion' => $this->n->forumAnswer->forumQuestion->id . '-' . Str::slug($this->n->forumAnswer->forumQuestion->theme),
                            'answer' => $this->n->forum_answer_id
                        ]);
                        break;
                    case 'New publication':
                        $title = $this->n->channel->name;
                        $icon = url(Storage::url($this->n->channel->logo));

                        switch ($this->nt) {
                            case 'article':
                                $body = $this->n->title;
                                $link = route('insight.article.show', ['channel' => $this->n->channel->slug, 'article' => $this->n->id . '-' . Str::slug($this->n->title)]);
                            case 'post':
                                $body = $this->n->content;
                                $link = route('insight.post.show', ['channel' => $this->n->channel->slug, 'post' => $this->n->id]);
                            case 'video':
                                $body = $this->n->title;
                                $link = route('insight.video.show', ['channel' => $this->n->channel->slug, 'video' => $this->n->id . '-' . Str::slug($this->n->title)]);
                        }
                        break;
                    default:
                        $body = __('New notification');
                }
                break;
        }

        $body = Str::limit(trim($body), 150);

        try {
            $beamsClient = new PushNotifications([
                'instanceId' => config('broadcasting.connections.pusher_beams.instance_id'),
                'secretKey' => config('broadcasting.connections.pusher_beams.secret_key'),
            ]);

            $beamsClient->publishToUsers(
                $chunkIds->toArray(),
                [
                    "web" => [
                        "notification" => [
                            "title" => $title,
                            "body" => $body,
                            "deep_link" => $link,
                            "icon" => $icon
                        ]
                    ]
                ]
            );
        } catch (Exception $e) {
            info('Exception - Job->SendWebNotifications: ' . $e->getMessage());
        }

        if ($this->userIds->count()) {
            SendWebNotifications::dispatch($this->userIds, $this->type, $this->nt, $this->n)->delay(now()->addSecond());
        }
    }
}
