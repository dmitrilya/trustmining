<?php

namespace App\Jobs;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\Notification;
use App\Models\Database\Coin;
use Exception;

class SendEmailNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $users;
    private string $type;
    private ?string $nt;
    private $n;
    private ?array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection $users, string $type, ?string $notificationableType, $notificationable, ?array $data = null)
    {
        $this->users = $users->unique('id');
        $this->type = $type;
        $this->nt = $notificationableType;
        $this->n = $notificationable;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = $this->users->shift();
        if (!$user || !$user->email) {
            $this->checkNext();
            return;
        }

        $originalLocale = App::getLocale();
        if (!empty($user->lang)) App::setLocale($user->lang);

        $title = __($this->type) ?? __('Новое уведомление');
        $body = '';
        $link = url('/');

        switch ($this->nt) {
            case 'message':
                $title = __('Новое сообщение от') . ' ' . $this->n->user->name;
                $body = $this->n->message;
                $link = $this->n->user->role->name == 'support'
                    ? route('support', ['chat' => true])
                    : route('chat', ['chat' => $this->n->chat_id]);
                break;

            case 'review':
                $rating = "";
                for ($i = 0; $i < $this->n->rating; $i++) $rating .= "⭐";
                $title = __('Новый отзыв') . ' ' . $rating;
                $body = $this->n->review;
                $link = route('company.reviews', ['user' => $this->n->reviewable->slug]);
                break;

            case 'moderation':
                $title = __('Результат модерации');
                $body = __('types.' . $this->n->moderationable_type);
                if ($this->n->comment) $body .= "\n\n" . $this->n->comment;
                break;

            case 'ad':
                if ($this->type === 'Price change') {
                    $lastModeration = $this->n->moderations()->whereNotNull('data->price')->latest()->limit(2)->get();
                    $price = $this->n->price != 0 ? $this->n->price : __('Цена по запросу');

                    $title = $this->n->asicVersion->asicModel->name;
                    $oldPrice = $lastModeration[1]->data['price'] ?? '0';
                    $coinAbbr = isset($lastModeration[1]->data['coin_id']) ? Coin::find($lastModeration[1]->data['coin_id'])->abbreviation : $this->n->coin->abbreviation;

                    $body = __('Изменение цены') . ": " . $oldPrice . $coinAbbr . " => " . $price . $this->n->coin->abbreviation;
                    $link = route('ads.show', ['adCategory' => $this->n->adCategory->name, 'ad' => $this->n->id]);
                }
                break;

            case 'coin':
                if ($this->type === 'Difficulty changing') {
                    $difficulties = $this->n->networkDifficulties()->latest()->take(2)->get();
                    $pd = $difficulties[1]->difficulty ?? 0;
                    $cd = $difficulties[0]->difficulty ?? 0;

                    $title = "{$this->n->name} — " . __('Изменение сложности');

                    if ($pd != $cd) {
                        $percent = ($cd >= $pd ? '+' : '-') . round(abs($cd - $pd) / $pd * 100, 2) . '%';
                        $body = __('Текущая сложность') . ': ' . number_format($cd) . " ({$percent})";
                    } else {
                        $difficultyData = $this->n->difficultyData();
                        $body = __('Прогноз следующей сложности') . ': ' . ($difficultyData['prediction'] >= 0 ? '+' : '') . $difficultyData['prediction'] . '%';
                    }
                    $link = route('metrics.network.difficulty', ['coin' => strtolower($this->n->name)]);
                }
                break;

            default:
                switch ($this->type) {
                    case 'Subscription renewal failed':
                        $body = __('Тариф сброшен до Базового. Реактивируйте его на странице тарифов.');
                        $link = route('tariffs');
                        break;
                    case 'Top up your balance (7 days)':
                        $body = __('Через 7 дней на балансе будет недостаточно средств для продления тарифа.');
                        $link = route('order.create');
                        break;
                    case 'Top up your balance (3 days)':
                        $body = __('Через 3 дня на балансе будет недостаточно средств для продления тарифа.');
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
                }
                break;
        }

        $unsubscribeLink = URL::temporarySignedRoute(
            'mail.redirect',
            now()->addDays(30),
            [
                'user_id' => $user->id,
                'redirect_to' => route('profile', ['tab' => 'notifications'])
            ]
        );

        $signedActionLink = url('/');
        if (!empty($link)) {
            $signedActionLink = URL::temporarySignedRoute(
                'mail.redirect',
                now()->addDays(7),
                [
                    'user_id' => $user->id,
                    'redirect_to' => $link
                ]
            );
        }

        try {
            Mail::to($user->email)->send(new Notification($title, $body, $signedActionLink, $unsubscribeLink));
        } catch (Exception $e) {
            info('Exception - Job->SendEmailNotifications: ' . $e->getMessage());
        }

        App::setLocale($originalLocale);

        $this->checkNext();
    }

    /**
     * Запуск следующего письма с задержкой в 1 секунду
     */
    private function checkNext()
    {
        if ($this->users->count()) {
            SendEmailNotifications::dispatch($this->users, $this->type, $this->nt, $this->n)->delay(now()->addSecond());
        }
    }
}
