<?php

use App\Http\Controllers\DaDataController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\TariffController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Company;

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

Route::get('/locale', [Controller::class, 'locale'])->name('locale');

Route::get('/', [Controller::class, 'home'])->name('home');
Route::get('/search', [Controller::class, 'search'])->name('search');
Route::get('/document', [Controller::class, 'document'])->name('document');
Route::get('/about', [Controller::class, 'about'])->name('about');
Route::get('/career', [Controller::class, 'career'])->name('career');
Route::get('/events', [Controller::class, 'events'])->name('events');

Route::get('/tariffs', [TariffController::class, 'index'])->name('tariffs');

Route::get('/offices', [OfficeController::class, 'index'])->name('offices');

Route::group(['prefix' => 'articles'], function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles');
    Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article');
});

Route::group(['prefix' => 'guides'], function () {
    Route::get('/', [GuideController::class, 'index'])->name('guides');
    Route::get('/guide/{guide}', [GuideController::class, 'show'])->name('guide');
});

Route::group(['prefix' => 'database'], function () {
    Route::get('/', [DatabaseController::class, 'index'])->name('database');
    Route::group(['prefix' => '{asicBrand}'], function () {
        Route::get('/', [DatabaseController::class, 'brand'])->name('database.brand');
        Route::group(['prefix' => '{asicModel}'], function () {
            Route::get('/', [DatabaseController::class, 'model'])->name('database.model');
            Route::get('/reviews', [DatabaseController::class, 'reviews'])->name('database.reviews');
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

Route::group(['prefix' => 'ads'], function () {
    Route::get('/', [AdController::class, 'index'])->name('ads');
    Route::get('/ad/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::get('/hostings', [HostingController::class, 'index'])->name('hostings');
});

Route::middleware('auth')->group(function () {
    Route::get('/address/suggestions', [DaDataController::class, 'suggestions'])->name('address.suggestions');

    Route::get('/tariff/{tariff}', [TariffController::class, 'show'])->name('tariff');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        Route::get('/notifications/check', [ProfileController::class, 'notificationsCheck'])->name('notifications.check');
    });

    Route::post('/passport/store', [PassportController::class, 'store'])->name('passport.store');

    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/chat/user/{user}', [ChatController::class, 'chat'])->name('chat.start');
    Route::get('/chats', [ChatController::class, 'index'])->name('chats');

    Route::middleware('in-chat')->group(function () {
        Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat');
        Route::post('/chat/{chat}/send', [ChatController::class, 'send'])->name('chat.send');
    });

    Route::group(['prefix' => 'company'], function () {
        Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
        Route::get('/edit', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('/update', [CompanyController::class, 'update'])->name('company.update');
    });

    Route::middleware('passport-moderated')->group(function () {
        Route::group(['prefix' => 'office'], function () {
            Route::get('/create', [OfficeController::class, 'create'])->name('office.create');
            Route::post('/store', [OfficeController::class, 'store'])->name('office.store');
            Route::get('/{office}/edit', [OfficeController::class, 'edit'])->name('office.edit');
            Route::put('/{office}/update', [OfficeController::class, 'update'])->name('office.update');
            Route::delete('/{office}/destroy', [OfficeController::class, 'destroy'])->name('office.destroy');
        });

        Route::middleware('office-moderated')->group(function () {
            Route::group(['prefix' => 'ads'], function () {
                Route::get('/create', [AdController::class, 'create'])->name('ads.create');
                Route::post('/store', [AdController::class, 'store'])->name('ads.store');
                Route::get('/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
                Route::put('/{ad}/update', [AdController::class, 'update'])->name('ads.update');
                Route::put('/{ad}/toggle-hidden', [AdController::class, 'toggleHidden'])->name('ads.toggle-hidden');
                Route::delete('/{ad}/destroy', [AdController::class, 'destroy'])->name('ads.destroy');
            });
        });

        Route::middleware('company-moderated')->group(function () {
            Route::group(['prefix' => 'hosting'], function () {
                Route::get('/create', [HostingController::class, 'create'])->name('hosting.create');
                Route::post('/store', [HostingController::class, 'store'])->name('hosting.store');
                Route::get('/{hosting}/edit', [HostingController::class, 'edit'])->name('hosting.edit');
                Route::put('/{hosting}/update', [HostingController::class, 'update'])->name('hosting.update');
                Route::delete('/{hosting}/destroy', [HostingController::class, 'destroy'])->name('hosting.destroy');
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

require __DIR__ . '/auth.php';
