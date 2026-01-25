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
use App\Http\Controllers\Blog\ArticleController;
use App\Http\Controllers\Blog\GuideController;
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
Route::get('/change-theme', [ProfileController::class, 'changeTheme'])->name('change-theme');

Route::get('/', [Controller::class, 'home'])->name('home');
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

Route::group(['prefix' => 'articles'], function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles');
    Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article');
});

Route::group(['prefix' => 'guides'], function () {
    Route::get('/', [GuideController::class, 'index'])->name('guides');
    Route::get('/{user:id}/guide/{guide}', [GuideController::class, 'show'])->scopeBindings()->name('guide');
});

Route::group(['prefix' => 'database'], function () {
    Route::get('/', [DatabaseController::class, 'index'])->name('database');
    Route::get('/get-models', [DatabaseController::class, 'getModels']);

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

Route::post('/order/webhook', [OrderController::class, 'webhook']);
Route::post('/order/invoice/webhook', [OrderController::class, 'invoiceWebhook']);
Route::post('/amocrm/webhook/uninstall', [AmoCRMController::class, 'handleUninstallWebhook']);
Route::post('/amocrm/webhook/{scope_id}', [ChatController::class, 'amocrmWebhook']);

Route::get('/phones/{phone}/show', [PhoneController::class, 'show'])->name('phone.show');

Route::middleware('auth')->group(function () {
    Route::post('/like', [Controller::class, 'like'])->name('like');

    Route::get('/amocrm/auth', [AmoCRMController::class, 'auth'])->name('amocrm.auth');

    Route::group(['prefix' => 'tg'], function () {
        Route::get('/auth', [Controller::class, 'tgAuth']);
        Route::patch('/dont-ask', [Controller::class, 'tgDontAsk']);
    });

    Route::group(['prefix' => 'guides'], function () {
        Route::get('/create', [GuideController::class, 'create'])->name('guide.create');
        Route::post('/store', [GuideController::class, 'store'])->name('guide.store');
        Route::middleware('owner')->group(function () {
            Route::get('/{guide}/edit', [GuideController::class, 'edit'])->name('guide.edit');
            Route::put('/{guide}/update', [GuideController::class, 'update'])->name('guide.update');
            Route::delete('/{guide}/destroy', [GuideController::class, 'destroy'])->name('guide.destroy');
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

require __DIR__ . '/auth.php';
