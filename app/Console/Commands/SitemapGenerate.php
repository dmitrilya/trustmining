<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\User\User;
use App\Models\Ad\AdCategory;
use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Database\GPUBrand;
use App\Models\Blog\BlogArticle;
use App\Models\Insight\Channel;
use App\Models\Database\Coin;
use App\Models\Forum\ForumCategory;
use App\Models\Morph\View;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate actual sitemap XML file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $host = 'https://trustmining.ru/';

        $out = '<?xml version="1.0" encoding="UTF-8"?>';
        $out .= '
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $out .= $this->addUrl('');
        $out .= $this->addUrl('hostings');
        $out .= $this->addUrl('services');
        $out .= $this->addUrl('cryptoexchangers');
        $out .= $this->addUrl('companies');
        $out .= $this->addUrl('warranty-check');

        foreach (AdCategory::select('name')->get() as $adCategory) {
            $out .= $this->addUrl('ads/' . $adCategory->name);
        }

        $out .= $this->addUrl('metrics');
        foreach (Coin::whereHas('networkHashrates')->select('name')->get() as $coin) {
            $out .= $this->addUrl('metrics/network/' . strtolower($coin->name) . '/hashrate');
        }

        foreach (Coin::whereHas('networkDifficulties')->select('name')->get() as $coin) {
            $out .= $this->addUrl('metrics/network/' . strtolower($coin->name) . '/difficulty');
        }

        $users = User::whereHas('offices', fn($q) => $q->where('moderation', 'false'))->with([
            'ads' => fn($q) => $q->whereHas('adCategory', fn($q1) => $q1->whereNotIn('name', ['miners', 'gpus']))->select(['id', 'ad_category_id', 'user_id', 'moderation', 'hidden']),
            'ads.adCategory:id,name',
            'hosting:user_id,moderation',
            'company:user_id,moderation',
            'offices:id,user_id'
        ])->select(['id', 'slug'])->get();

        foreach ($users as $user) {
            $out .= $this->addUrl('company/' . $user->slug . '/shop');
            if ($user->hosting && !$user->hosting->moderation) $out .= $this->addUrl('company/' . $user->slug . '/hosting');
            if ($user->company && !$user->company->moderation) $out .= $this->addUrl('company/' . $user->slug . '/about');

            foreach ($user->ads->where('moderation', false)->where('hidden', false) as $ad) {
                $out .= $this->addUrl('ads/' . $ad->adCategory->name . '/' . $ad->id);
            }

            $out .= $this->addUrl('company/' . $user->slug . '/offices');
            foreach ($user->offices->where('moderation', false) as $office) {
                $out .= $this->addUrl('company/' . $user->slug . '/offices/' . $office->id);
            }

            $out .= $this->addUrl('company/' . $user->slug . '/reviews');
        }

        $out .= $this->addUrl('asic-miners');
        $out .= $this->addUrl('calculator');

        foreach (
            AsicBrand::select(['id', 'slug'])->with([
                'asicModels:id,asic_brand_id,slug',
                'asicModels.asicVersions:id,asic_model_id,hashrate,measurement',
                'asicModels.asicVersions.moderatedAds:id,asic_version_id,user_id',
                'asicModels.asicVersions.moderatedAds.user:id,slug'
            ])->get() as $asicBrand
        ) {
            $out .= $this->addUrl('asic-miners/' . $asicBrand->slug);
            foreach ($asicBrand->asicModels as $asicModel) {
                $out .= $this->addUrl('asic-miners/' . $asicBrand->slug . '/' . $asicModel->slug);
                $out .= $this->addUrl('asic-miners/' . $asicBrand->slug . '/' . $asicModel->slug . '/reviews');
                $out .= $this->addUrl('calculator/' . $asicModel->slug);
                foreach ($asicModel->asicVersions as $asicVersion) {
                    $out .= $this->addUrl('asic-miners/' . $asicBrand->slug . '/' . $asicModel->slug . '/' . $asicVersion->hashrate . $asicVersion->measurement);
                    $out .= $this->addUrl('calculator/' . $asicModel->slug . '/' . $asicVersion->hashrate);
                    foreach ($asicVersion->moderatedAds as $ad) {
                        $out .= $this->addUrl('asic-miners/' . $asicBrand->slug . '/' . $asicModel->slug . '/' . $asicVersion->hashrate . $asicVersion->measurement . '/ads/' . $ad->user->slug . '-' . $ad->id);
                    }
                }
            }
        }

        $models = AsicModel::whereIn('id', View::where('viewable_type', 'asic-model')->select('viewable_id', DB::raw('count(*) as views_count'))
            ->groupBy('viewable_id')->orderBy('views_count', 'desc')->limit(50)->pluck('viewable_id'))->pluck('slug');
        $count = $models->count();

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $out .= $this->addUrl("asic-miners/compare/$models[$i]-vs-$models[$j]");
            }
        }

        $out .= $this->addUrl('gpus');

        foreach (
            GPUBrand::select(['id', 'slug'])->with([
                'gpuModels:id,gpu_brand_id,slug',
                'gpuModels.moderatedAds:id,gpu_model_id,user_id',
                'gpuModels.moderatedAds.user:id,slug'
            ])->get() as $gpuBrand
        ) {
            $out .= $this->addUrl('gpus/' . $gpuBrand->slug);
            foreach ($gpuBrand->gpuModels as $gpuModel) {
                $out .= $this->addUrl('gpus/' . $gpuBrand->slug . '/' . $gpuModel->slug);
                $out .= $this->addUrl('gpus/' . $gpuBrand->slug . '/' . $gpuModel->slug . '/reviews');
                foreach ($gpuModel->moderatedAds as $ad) {
                    $out .= $this->addUrl('gpus/' . $gpuBrand->slug . '/' . $gpuModel->slug . '/ads/' . $ad->user->slug . '-' . $ad->id);
                }
            }
        }

        $out .= $this->addUrl('blog');
        foreach (BlogArticle::select(['id', 'title'])->get() as $article) {
            $out .= $this->addUrl('blog/article/' . $article->id . '-' . Str::slug($article->title));
        }

        $out .= $this->addUrl('insight');
        foreach (
            Channel::select(['id', 'slug'])
                ->with(['moderatedArticles:id,title,channel_id', 'moderatedPosts:id,channel_id', 'moderatedVideos:id,title,channel_id'])->get() as $channel
        ) {
            $out .= $this->addUrl('insight/' . $channel->slug);

            foreach ($channel->moderatedArticles as $article)
                $out .= $this->addUrl('insight/' . $channel->slug . '/article/' . $article->id . '-' . Str::slug($article->title));

            foreach ($channel->moderatedPosts as $post)
                $out .= $this->addUrl('insight/' . $channel->slug . '/post/' . $post->id);

            foreach ($channel->moderatedVideos as $video)
                $out .= $this->addUrl('insight/' . $channel->slug . '/video/' . $video->id . '-' . Str::slug($video->title));
        }

        $out .= $this->addUrl('forum');

        foreach (ForumCategory::select(['id', 'slug'])->with(['forumSubcategories:id,forum_category_id,slug', 'forumSubcategories.forumQuestions:id,forum_subcategory_id,theme'])->get() as $forumCategory) {
            $forumCategoryName = $forumCategory->slug;
            $out .= $this->addUrl('forum/' . $forumCategoryName);
            foreach ($forumCategory->forumSubcategories as $forumSubcategory) {
                $forumSubcategoryName = $forumSubcategory->slug;
                $out .= $this->addUrl('forum/' . $forumCategoryName . '/' . $forumSubcategoryName);
                foreach ($forumSubcategory->forumQuestions as $forumQuestion)
                    $out .= $this->addUrl('forum/' . $forumCategoryName . '/' . $forumSubcategoryName . '/' . $forumQuestion->id . '-' . Str::slug($forumQuestion->theme));
            }
        }

        $out .= $this->addUrl('support');
        $out .= $this->addUrl('support?chat=1');
        $out .= $this->addUrl('document?path=documents/privacy.pdf');
        $out .= $this->addUrl('document?path=documents/agreement.pdf');
        $out .= $this->addUrl('tariffs');
        $out .= $this->addUrl('roadmap');
        $out .= $this->addUrl('login');
        $out .= $this->addUrl('register');
        $out .= $this->addUrl('forgot-password');

        $out .= '
</urlset>';

        file_put_contents('public_html/sitemap.xml', $out);

        return Command::SUCCESS;
    }

    private function addUrl($url)
    {
        return '
    <url><loc>https://trustmining.ru/' . $url . '</loc></url>';
    }
}
