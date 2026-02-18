<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale(app()->getLocale());

        Storage::disk('private')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return URL::temporarySignedRoute(
                'private.temp',
                $expiration,
                array_merge($options, ['path' => $path])
            );
        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject(__('Verify Email Address'))
                ->line(__('Please click the button below to verify your email address and activate your account.'))
                ->action(__('Activate account'), $url)
                ->line(__('If you did not create an account, no further action is required.'));
        });

        Relation::enforceMorphMap([
            'channel' => \App\Models\Insight\Channel::class,
            'series' => \App\Models\Insight\Series::class,
            'article' => \App\Models\Insight\Content\Article::class,
            'post' => \App\Models\Insight\Content\Post::class,
            'video' => \App\Models\Insight\Content\Video::class,
            'comment' => \App\Models\Insight\Comment::class,

            'user' => \App\Models\User\User::class,
            'phone' => \App\Models\User\Phone::class,
            'company' => \App\Models\User\Company::class,
            'office' => \App\Models\User\Office::class,
            'passport' => \App\Models\User\Passport::class,
            'hosting' => \App\Models\Ad\Hosting::class,
            'ad' => \App\Models\Ad\Ad::class,
            'track' => \App\Models\Ad\Track::class,
            'message' => \App\Models\Chat\Message::class,
            'asic-brand' => \App\Models\Database\AsicBrand::class,
            'asic-model' => \App\Models\Database\AsicModel::class,
            'gpu-model' => \App\Models\Database\GPUModel::class,
            'blog-article' => \App\Models\Blog\BlogArticle::class,
            'review' => \App\Models\Morph\Review::class,
            'moderation' => \App\Models\Morph\Moderation::class,

            'forum-question' => \App\Models\Forum\ForumQuestion::class,
            'forum-answer' => \App\Models\Forum\ForumAnswer::class,
            'forum-comment' => \App\Models\Forum\ForumComment::class,
        ]);
    }
}
