<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

use App\Http\Traits\AdTrait;
use App\Http\Traits\HostingTrait;
use App\Models\Ad\AdCategory;
use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Database\GPUModel;
use App\Models\Forum\ForumQuestion;
use App\Models\Insight\Channel;

class CacheHomePageData extends Command
{
    use AdTrait, HostingTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'homepage:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $location = session('user_location');
        $miners = $this->getAds(null, AdCategory::where('name', 'miners')->first());
        $monthAgo = now()->subMonth();

        if ($location && $location['source'] == 'geo') $miners->orderByRaw("CASE WHEN cities.name = ? THEN 1 ELSE 0 END DESC", [$location['city']]);

        Cache::put('home_page_data', [
            'asicBrands' => AsicBrand::select(['id', 'name', 'slug'])->withCount(['views as views_count' => function ($query) use ($monthAgo) {
                $query->where('created_at', '>=', $monthAgo);
            }])->orderByDesc('views_count')->get(),
            'asicModels' => AsicModel::select(['id', 'name', 'slug', 'asic_brand_id'])->with(['asicBrand:id,name,slug'])
                ->withCount(['views as views_count' => function ($query) use ($monthAgo) {
                    $query->where('created_at', '>=', $monthAgo);
                }])->orderByDesc('views_count')->limit(10)->get(),
            'gpuModels' => GPUModel::select(['id', 'name', 'slug', 'images', 'max_power', 'gpu_brand_id'])->with(['gpuBrand:id,name,slug'])
                ->withCount('ads')->orderByDesc('ads_count')->limit(9)->get(),
            'miners' => $miners->orderByDesc('ads.ordering_id')->limit(9)->get(),
            'hostings' => $this->getHostings(null)->inRandomOrder()->limit(9)->get(),
            'forumQuestions' => ForumQuestion::where('published', true)->select(['id', 'forum_subcategory_id', 'theme', 'created_at'])
                ->with(['forumSubcategory:id,name,slug,forum_category_id', 'forumSubcategory.forumCategory:id,name,slug'])
                ->withCount('moderatedForumAnswers')->withCount('views')->latest()->limit(3)->get(),
            'topChannels' => Channel::select(['id', 'name', 'slug', 'logo'])->withCount('activeSubscribers')->orderByDesc('active_subscribers_count')->limit(4)->get()
        ]);

        return Command::SUCCESS;
    }
}
