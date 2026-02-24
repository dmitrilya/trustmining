<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\Ad\AdController;
use App\Http\Controllers\Ad\HostingController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\PassportController;
use App\Http\Controllers\User\PhoneController;
use App\Http\Controllers\User\CompanyController;
use App\Http\Controllers\User\OfficeController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\TariffController;
use App\Http\Controllers\Morph\ReviewController;
use App\Http\Controllers\Morph\ModerationController;
use App\Http\Controllers\Blog\BlogArticleController;
use App\Http\Controllers\Insight\InsightController;
use App\Http\Controllers\Insight\ChannelController;
use App\Http\Controllers\Insight\SeriesController;
use App\Http\Controllers\Insight\Content\ArticleController;
use App\Http\Controllers\Insight\Content\PostController;
use App\Http\Controllers\Insight\Content\VideoController;
use App\Http\Controllers\Insight\CommentController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Forum\ForumQuestionController;
use App\Http\Controllers\Forum\ForumAnswerController;
use App\Http\Controllers\Forum\ForumCommentController;
use App\Http\Controllers\CRM\AmoCRMController;
use App\Http\Controllers\Chat\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('private/temp', function (Request $request) {
    if (!$request->hasValidSignature()) {
        abort(401);
    }

    return Storage::disk('private')->download($request->path);
})->name('private.temp');

Route::get('/locale', [ProfileController::class, 'locale'])->name('locale');
Route::post('/location', [ProfileController::class, 'location'])->name('location');
Route::get('/change-theme', [ProfileController::class, 'changeTheme'])->name('change-theme');

Route::get('/', [Controller::class, 'home'])->name('home');
Route::get('/about', [Controller::class, 'about'])->name('about');
Route::get('/search', [Controller::class, 'search'])->name('search');
Route::get('/document', [Controller::class, 'document'])->name('document');
Route::get('/roadmap', [Controller::class, 'roadmap'])->name('roadmap');
Route::get('/career', [Controller::class, 'career'])->name('career');
Route::get('/events', [Controller::class, 'events'])->name('events');
Route::get('/warranty-check', [Controller::class, 'warranty'])->name('warranty');
Route::get('/top', [Controller::class, 'top'])->name('top');
Route::get('/rating-asic-miners', [Controller::class, 'asicRating'])->name('asic-rating');

Route::group(['prefix' => 'calculator'], function () {
    Route::get('/', [Controller::class, 'calculator'])->name('calculator');
    Route::get('/app', [Controller::class, 'calculatorApp'])->name('calculator.app');
    Route::get('/get-models', [Controller::class, 'calculatorModels'])->name('calculator-models');
    Route::get('/{asicModel}', [Controller::class, 'calculator'])->name('calculator.model');
    Route::get('/{asicModel}/{asicVersion:hashrate}', [Controller::class, 'calculator'])->name('calculator.modelver');
});

Route::group(['prefix' => 'metrics'], function () {
    Route::get('/', [MetricsController::class, 'index'])->name('metrics');
    Route::group(['prefix' => 'network'], function () {
        Route::group(['prefix' => '{coin:name}'], function () {
            Route::get('/hashrate', [MetricsController::class, 'hashrate'])->name('metrics.network.hashrate');
            Route::get('/get-hashrate', [MetricsController::class, 'getHashrate'])->name('metrics.network.get_hashrate');
            Route::get('/difficulty', [MetricsController::class, 'difficulty'])->name('metrics.network.difficulty');
            Route::get('/get-difficulty', [MetricsController::class, 'getDifficulty'])->name('metrics.network.get_difficulty');
        });
    });
});

Route::get('/tariffs', [TariffController::class, 'index'])->name('tariffs');
Route::get('/offices', [OfficeController::class, 'index'])->name('offices');
Route::get('/services', [OfficeController::class, 'services'])->name('services');
Route::get('/cryptoexchangers', [OfficeController::class, 'cryptoexchangers'])->name('cryptoexchangers');
Route::get('/companies', [ShopController::class, 'shops'])->name('companies');

Route::group(['prefix' => 'dadata'], function () {
    Route::group(['prefix' => 'suggestions'], function () {
        Route::get('/address', [Controller::class, 'dadataSuggsAddress'])->name('dadata.suggs.address');
        Route::get('/city', [Controller::class, 'dadataSuggsCity'])->name('adadata.suggs.city');
    });
});

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [BlogArticleController::class, 'index'])->name('blog');
    Route::get('/article/{article}', [BlogArticleController::class, 'show'])->name('blog.article');
});

Route::group(['prefix' => 'database'], function () {
    Route::get('/', [DatabaseController::class, 'index'])->name('database');
    Route::get('/get-models', [DatabaseController::class, 'getModels']);

    Route::get('/gpu/{gpuBrand}/{gpuModel}', [DatabaseController::class, 'gpuModel'])->name('database.gpu.model');
    Route::get('/gpu/{gpuBrand}/{gpuModel}/reviews', [DatabaseController::class, 'gpuReviews'])->name('database.gpu.reviews');

    Route::group(['prefix' => '{asicBrand}'], function () {
        Route::get('/', [DatabaseController::class, 'brand'])->name('database.brand');
        Route::get('/get-models', [DatabaseController::class, 'getModels']);

        Route::group(['prefix' => '{asicModel}'], function () {
            Route::get('/', [DatabaseController::class, 'model'])->name('database.model');
            Route::get('/reviews', [DatabaseController::class, 'reviews'])->name('database.reviews');
            Route::get('/{asicVersion:hashrate}', [DatabaseController::class, 'version'])->name('database.version');
        });
    });
});

Route::group(['prefix' => 'support'], function () {
    Route::get('/', [Controller::class, 'support'])->name('support');
    Route::get('/question', [Controller::class, 'supportQuestion'])->name('support.question');
});

Route::group(['prefix' => 'company/{user}'], function () {
    Route::get('/shop', [ShopController::class, 'shop'])->name('company');
    Route::get('/reviews', [ShopController::class, 'reviews'])->name('company.reviews');
    Route::get('/about', [ShopController::class, 'aboutCompany'])->name('company.about');
    Route::get('/hosting', [ShopController::class, 'hosting'])->name('company.hosting');
    Route::get('/offices', [ShopController::class, 'offices'])->name('company.offices');
    Route::get('/offices/{office}', [ShopController::class, 'office'])->name('company.office');
});

Route::get('/hostings', [HostingController::class, 'index'])->name('hostings');
Route::get('/get-hostings', [HostingController::class, 'getHostingsCarousel'])->name('hostings.get');

Route::post('/order/webhook', [OrderController::class, 'webhook']);
Route::post('/order/invoice/webhook', [OrderController::class, 'invoiceWebhook']);
Route::post('/amocrm/webhook/uninstall', [AmoCRMController::class, 'handleUninstallWebhook']);
Route::post('/amocrm/webhook/{scope_id}', [ChatController::class, 'amocrmWebhook']);

Route::get('/phones/{user}/show', [PhoneController::class, 'show'])->name('phone.show');

Route::middleware('auth')->group(function () {
    Route::post('/like', [Controller::class, 'like'])->name('like');

    Route::get('/amocrm/auth', [AmoCRMController::class, 'auth'])->name('amocrm.auth');

    Route::group(['prefix' => 'tg'], function () {
        Route::get('/auth', [Controller::class, 'tgAuth']);
        Route::patch('/dont-ask', [Controller::class, 'tgDontAsk']);
    });

    Route::group(['prefix' => 'insight'], function () {
        Route::post('/channel/check-slug', [ChannelController::class, 'checkSlug'])->name('insight.channel.check-slug');
        Route::get('/channel/create', [ChannelController::class, 'create'])->name('insight.channel.create');
        Route::post('/channel/store', [ChannelController::class, 'store'])->name('insight.channel.store');
        Route::post('/subscriptions', [InsightController::class, 'subscriptions'])->name('insight.subscriptions.index');
        Route::post('/comment/{comment}/reaction/{type}', [CommentController::class, 'reaction'])->name('insight.comment.reaction');
        Route::middleware('owner')->group(function () {
            Route::get('/channel/{channel}/statistics', [ChannelController::class, 'statistics'])->name('insight.channel.statistics');
            Route::get('/channel/{channel}/edit', [ChannelController::class, 'edit'])->name('insight.channel.edit');
            Route::put('/channel/{channel}/update', [ChannelController::class, 'update'])->name('insight.channel.update');
            Route::delete('/channel/{channel}/destroy', [ChannelController::class, 'destroy'])->name('insight.channel.destroy');
        });

        Route::group(['prefix' => '/{channel}'], function () {
            Route::post('/toggle-subscription', [ChannelController::class, 'toggleSubscription'])->name('insight.channel.subscription');
            Route::post('/series/store', [SeriesController::class, 'store'])->name('insight.series.store');
            Route::put('/series/{series}/update', [SeriesController::class, 'update'])->scopeBindings()->name('insight.series.update');
            Route::delete('/series/{series}/destroy', [SeriesController::class, 'destroy'])->scopeBindings()->name('insight.series.destroy');
            Route::get('/article/create', [ArticleController::class, 'create'])->name('insight.article.create');
            Route::post('/article/store', [ArticleController::class, 'store'])->name('insight.article.store');
            Route::put('/article/{article}/update', [ArticleController::class, 'update'])->scopeBindings()->name('insight.article.update');
            Route::delete('/article/{article}/destroy', [ArticleController::class, 'destroy'])->scopeBindings()->name('insight.article.destroy');
            Route::post('/article/{article}/comment', [ArticleController::class, 'comment'])->scopeBindings()->name('insight.article.comment');
            Route::get('/video/create', [VideoController::class, 'create'])->name('insight.video.create');
            Route::post('/video/store', [VideoController::class, 'store'])->name('insight.video.store');
            Route::put('/video/{video}/update', [VideoController::class, 'update'])->scopeBindings()->name('insight.video.update');
            Route::delete('/video/{video}/destroy', [VideoController::class, 'destroy'])->scopeBindings()->name('insight.video.destroy');
            Route::post('/video/{video}/comment', [VideoController::class, 'comment'])->scopeBindings()->name('insight.video.comment');
            Route::get('/post/create', [PostController::class, 'create'])->name('insight.post.create');
            Route::post('/post/store', [PostController::class, 'store'])->name('insight.post.store');
            Route::put('/post/{post}/update', [PostController::class, 'update'])->scopeBindings()->name('insight.post.update');
            Route::delete('/post/{post}/destroy', [PostController::class, 'destroy'])->scopeBindings()->name('insight.post.destroy');
            Route::post('/post/{post}/comment', [PostController::class, 'comment'])->scopeBindings()->name('insight.post.comment');
        });
    });

    Route::get('/tariff/{tariff}', [TariffController::class, 'show'])->name('tariff');

    Route::group(['prefix' => 'order'], function () {
        Route::get('/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/store', [OrderController::class, 'store'])->name('order.store');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        Route::get('/notifications/check', [ProfileController::class, 'notificationsCheck'])->name('notifications.check');
    });

    Route::group(['prefix' => 'forum/questions'], function () {
        Route::get('/', [ForumQuestionController::class, 'myQuestions'])->name('forum.question.index');
        Route::get('/publish/{forumQuestion}', [ForumQuestionController::class, 'publish'])->middleware('owner')->name('forum.question.publish');
    });

    Route::group(['prefix' => 'reviews'], function () {
        Route::post('/store', [ReviewController::class, 'store'])->name('review.store');
        Route::get('/{review}', [ReviewController::class, 'show'])->middleware('role:admin,moderator,support')->name('review.show');
        Route::delete('/{review}/destroy', [ReviewController::class, 'destroy'])->middleware('owner')->name('review.destroy');
    });

    Route::get('/chat/user/{user}', [ChatController::class, 'chat'])->name('chat.start');
    Route::get('/chats', [ChatController::class, 'index'])->name('chats');

    Route::middleware('in-chat')->group(function () {
        Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat');
        Route::post('/chat/{chat}/send', [ChatController::class, 'send'])->name('chat.send');
    });

    Route::group(['prefix' => 'phones'], function () {
        Route::post('/store', [PhoneController::class, 'store'])->name('phone.store');
        Route::middleware('owner')->group(function () {
            Route::put('/{phone}/update', [PhoneController::class, 'update'])->name('phone.update');
            Route::delete('/{phone}/destroy', [PhoneController::class, 'destroy'])->name('phone.destroy');
        });
    });

    Route::post('/passport/store', [PassportController::class, 'store'])->name('passport.store');

    Route::group(['prefix' => 'companies'], function () {
        Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
        Route::middleware('owner')->group(function () {
            Route::get('/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
            Route::put('/{company}/update', [CompanyController::class, 'update'])->name('company.update');
        });
    })->middleware('verified');

    Route::middleware(['identified', 'verified'])->group(function () {
        Route::group(['prefix' => 'offices'], function () {
            Route::get('/create', [OfficeController::class, 'create'])->name('office.create');
            Route::post('/store', [OfficeController::class, 'store'])->name('office.store');
            Route::middleware('owner')->group(function () {
                Route::get('/{office}/edit', [OfficeController::class, 'edit'])->name('office.edit');
                Route::put('/{office}/update', [OfficeController::class, 'update'])->name('office.update');
                Route::delete('/{office}/destroy', [OfficeController::class, 'destroy'])->name('office.destroy');
            });
        });

        Route::middleware('has-office')->group(function () {
            Route::group(['prefix' => 'ads'], function () {
                Route::get('/create', [AdController::class, 'create'])->name('ad.create');
                Route::post('/store', [AdController::class, 'store'])->name('ad.store');
                Route::get('/edit-mass', [AdController::class, 'editMass'])->name('ad.edit.mass');
                Route::post('/update-mass', [AdController::class, 'updateMass'])->name('ad.update.mass');
                Route::get('/statistics', [StatisticsController::class, 'ads'])->name('ad.statistics');
                Route::get('/statistics/get-ads-statistics', [StatisticsController::class, 'adsStatistics'])->name('ad.get-statistics');
                Route::middleware('owner')->group(function () {
                    Route::get('/{ad}/edit', [AdController::class, 'edit'])->name('ad.edit');
                    Route::put('/{ad}/update', [AdController::class, 'update'])->name('ad.update');
                    Route::put('/{ad}/toggle-hidden', [AdController::class, 'toggleHidden'])->name('ad.toggle-hidden');
                    Route::delete('/{ad}/destroy', [AdController::class, 'destroy'])->name('ad.destroy');
                });
            });
        });

        Route::middleware('has-company')->group(function () {
            Route::group(['prefix' => 'hostings'], function () {
                Route::get('/create', [HostingController::class, 'create'])->name('hosting.create');
                Route::post('/store', [HostingController::class, 'store'])->name('hosting.store');
                Route::middleware('owner')->group(function () {
                    Route::get('/{hosting}/edit', [HostingController::class, 'edit'])->name('hosting.edit');
                    Route::put('/{hosting}/update', [HostingController::class, 'update'])->name('hosting.update');
                    Route::delete('/{hosting}/destroy', [HostingController::class, 'destroy'])->name('hosting.destroy');
                });
            });
        });
    });

    Route::middleware('role:admin,moderator')->group(function () {
        Route::group(['prefix' => 'moderations'], function () {
            Route::get('/', [ModerationController::class, 'index'])->name('moderations');
            Route::get('/{moderation}', [ModerationController::class, 'show'])->name('moderation');
            Route::put('/{moderation}/accept', [ModerationController::class, 'accept'])->name('moderation.accept');
            Route::put('/{moderation}/decline', [ModerationController::class, 'decline'])->name('moderation.decline');
        });
    });
});

Route::group(['prefix' => 'ads/{adCategory:name}'], function () {
    Route::get('/', [AdController::class, 'index'])->name('ads');
    Route::get('/get-ads', [AdController::class, 'getAdsCarousel'])->name('ads.get');
    Route::get('/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::post('/{ad}/track', [AdController::class, 'track'])->name('ads.track');
});

Route::get('/hostings/{hosting}/contract_deficiencies', [HostingController::class, 'getContractDeficiencies'])->name('hosting.contract_deficiencies');

Route::group(['prefix' => 'forum'], function () {
    Route::get('/', [ForumController::class, 'index'])->name('forum');
    Route::get('/question/create', [ForumQuestionController::class, 'create'])->name('forum.question.create');
    Route::middleware('auth')->group(function () {
        Route::put('/avatar/update', [ForumController::class, 'updateAvatar'])->name('forum.avatar.update');
        Route::group(['prefix' => 'question'], function () {
            Route::post('/store', [ForumQuestionController::class, 'store'])->name('forum.question.store');
            Route::put('/{forumQuestion}/update', [ForumQuestionController::class, 'update'])->middleware('owner')->name('forum.question.update');
            Route::delete('/{forumQuestion}/destroy', [ForumQuestionController::class, 'destroy'])->middleware('owner')->name('forum.question.destroy');
        });
        Route::group(['prefix' => 'answer'], function () {
            Route::post('/store', [ForumAnswerController::class, 'store'])->name('forum.answer.store');
            Route::put('/{forumAnswer}/update', [ForumAnswerController::class, 'update'])->middleware('owner')->name('forum.answer.update');
            Route::delete('/{forumAnswer}/destroy', [ForumAnswerController::class, 'destroy'])->middleware('owner')->name('forum.answer.destroy');
        });
        Route::group(['prefix' => 'comment'], function () {
            Route::post('/store', [ForumCommentController::class, 'store'])->name('forum.comment.store');
            Route::put('/{forumComment}/update', [ForumCommentController::class, 'update'])->middleware('owner')->name('forum.comment.update');
            Route::delete('/{forumComment}/destroy', [ForumCommentController::class, 'destroy'])->middleware('owner')->name('forum.comment.destroy');
        });
    });
    Route::group(['prefix' => '{forumCategory}'], function () {
        Route::get('/', [ForumController::class, 'category'])->name('forum.category');
        Route::group(['prefix' => '{forumSubcategory}'], function () {
            Route::get('/', [ForumController::class, 'subcategory'])->name('forum.subcategory');
            Route::get('/{forumQuestion}', [ForumQuestionController::class, 'show'])->name('forum.question.show');
        });
    });
});

Route::group(['prefix' => 'insight'], function () {
    Route::get('/', [InsightController::class, 'index'])->name('insight.index');
    Route::get('/articles', [ArticleController::class, 'index'])->name('insight.article.index');
    Route::get('/article/get-new', [InsightController::class, 'getNewArticles'])->name('insight.article.get-new');
    Route::get('/article/get-popular', [InsightController::class, 'getNewArticles'])->name('insight.article.get-popular');
    Route::get('/posts', [PostController::class, 'index'])->name('insight.post.index');
    Route::get('/post/get-new', [InsightController::class, 'getNewPosts'])->name('insight.post.get-new');
    Route::get('/post/get-popular', [InsightController::class, 'getNewPosts'])->name('insight.post.get-popular');
    Route::get('/videos', [VideoController::class, 'index'])->name('insight.video.index');
    Route::get('/video/get-new', [InsightController::class, 'getNewVideos'])->name('insight.video.get-new');
    Route::get('/video/get-popular', [InsightController::class, 'getNewVideos'])->name('insight.video.get-popular');
    Route::group(['prefix' => '{channel}'], function () {
        Route::get('/', [ChannelController::class, 'show'])->name('insight.channel.show');
        Route::get('/article/get-new', [ChannelController::class, 'getNewArticles'])->name('insight.channel.article.get-new');
        Route::get('/article/get-popular', [ChannelController::class, 'getNewArticles'])->name('insight.channel.article.get-popular');
        Route::get('/post/get-new', [ChannelController::class, 'getNewPosts'])->name('insight.channel.post.get-new');
        Route::get('/post/get-popular', [ChannelController::class, 'getNewPosts'])->name('insight.channel.post.get-popular');
        Route::get('/video/get-new', [ChannelController::class, 'getNewVideos'])->name('insight.channel.video.get-new');
        Route::get('/video/get-popular', [ChannelController::class, 'getNewVideos'])->name('insight.channel.video.get-popular');
        Route::group(['prefix' => '/series/{series}'], function () {
            Route::get('/', [SeriesController::class, 'show'])->name('insight.channel.series.show');
            Route::get('/article/get-new', [SeriesController::class, 'getNewArticles'])->name('insight.channel.series.article.get-new');
            Route::get('/article/get-popular', [SeriesController::class, 'getNewArticles'])->name('insight.channel.series.article.get-popular');
            Route::get('/post/get-new', [SeriesController::class, 'getNewPosts'])->name('insight.channel.series.post.get-new');
            Route::get('/post/get-popular', [SeriesController::class, 'getNewPosts'])->name('insight.channel.series.post.get-popular');
            Route::get('/video/get-new', [SeriesController::class, 'getNewVideos'])->name('insight.channel.series.video.get-new');
            Route::get('/video/get-popular', [SeriesController::class, 'getNewVideos'])->name('insight.channel.series.video.get-popular');
        });
        Route::get('/article/{article}', [ArticleController::class, 'show'])->name('insight.article.show');
        Route::get('/post/{post}', [PostController::class, 'show'])->name('insight.post.show');
        Route::get('/video/{video}', [VideoController::class, 'show'])->name('insight.video.show');
    });
});

require __DIR__ . '/auth.php';
