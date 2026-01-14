<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\User\User;
use App\Models\Ad\AdCategory;
use App\Models\Database\AsicBrand;
use App\Models\Blog\Article;
use App\Models\Blog\Guide;
use App\Models\Database\Coin;
use App\Models\Forum\ForumCategory;

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

        $users = User::where(
            fn(Builder $q) => $q->whereHas('ads', fn(Builder $query) => $query->where('moderation', 'false')->where('hidden', 'false'))
                ->orWhereHas('hosting', fn(Builder $query) => $query->where('moderation', 'false'))
        )->with([
            'ads:id,ad_category_id,user_id,moderation,hidden',
            'ads.adCategory:id,name',
            'hosting:user_id,moderation',
            'company:user_id,moderation',
            'offices:id,user_id'
        ])->select(['id', 'url_name'])->get();

        foreach ($users as $user) {
            $out .= $this->addUrl('company/' . $user->url_name . '/shop');
            if ($user->hosting && !$user->hosting->moderation) $out .= $this->addUrl('company/' . $user->url_name . '/hosting');
            if ($user->company && !$user->company->moderation) $out .= $this->addUrl('company/' . $user->url_name . '/about');

            foreach ($user->ads->where('moderation', false)->where('hidden', false) as $ad) {
                $out .= $this->addUrl('ads/' . $ad->adCategory->name . '/' . $ad->id);
            }

            $out .= $this->addUrl('company/' . $user->url_name . '/offices');
            foreach ($user->offices->where('moderation', false) as $office) {
                $out .= $this->addUrl('company/' . $user->url_name . '/offices/' . $office->id);
            }

            $out .= $this->addUrl('company/' . $user->url_name . '/reviews');
        }

        $out .= $this->addUrl('database');
        $out .= $this->addUrl('calculator');

        foreach (AsicBrand::select(['id', 'name'])->with(['asicModels:id,asic_brand_id,name', 'asicModels.asicVersions:asic_model_id,hashrate'])->get() as $asicBrand) {
            $asicBrandName = strtolower(str_replace(' ', '_', $asicBrand->name));
            $out .= $this->addUrl('database/' . $asicBrandName);
            foreach ($asicBrand->asicModels as $asicModel) {
                $asicModelName = strtolower(str_replace(' ', '_', $asicModel->name));
                $out .= $this->addUrl('database/' . $asicBrandName . '/' . $asicModelName);
                $out .= $this->addUrl('database/' . $asicBrandName . '/' . $asicModelName . '/reviews');
                $out .= $this->addUrl('calculator/' . $asicModelName);
                foreach ($asicModel->asicVersions as $asicVersion) {
                    $out .= $this->addUrl('database/' . $asicBrandName . '/' . $asicModelName . '/' . $asicVersion->hashrate);
                    $out .= $this->addUrl('calculator/' . $asicModelName . '/' . $asicVersion->hashrate);
                }
            }
        }

        $out .= $this->addUrl('articles');
        foreach (Article::select(['id', 'title'])->get() as $article) {
            $out .= $this->addUrl('articles/article/' . $article->id . '-' . mb_strtolower(str_replace(' ', '-', $article->title)));
        }
        $out .= $this->addUrl('guides');
        foreach (Guide::select(['id', 'title', 'user_id'])->with(['user:id'])->get() as $guide) {
            $out .= $this->addUrl('guides/' . $guide->user->id . '/guide/' . $guide->id . '-' . mb_strtolower(str_replace(' ', '-', $guide->title)));
        }

        $out .= $this->addUrl('forum');

        foreach (ForumCategory::select(['id', 'name'])->with(['forumSubcategories:id,forum_category_id,name', 'forumSubcategories.forumQuestions:id,forum_subcategory_id,theme'])->get() as $forumCategory) {
            $forumCategoryName = strtolower(str_replace(' ', '_', $forumCategory->name));
            $out .= $this->addUrl('forum/' . $forumCategoryName);
            foreach ($forumCategory->forumSubcategories as $forumSubcategory) {
                $forumSubcategoryName = strtolower(str_replace(' ', '_', $forumSubcategory->name));
                $out .= $this->addUrl('forum/' . $forumCategoryName . '/' . $forumSubcategoryName);
                foreach ($forumSubcategory->forumQuestions as $forumQuestion) {
                    $out .= $this->addUrl('forum/' . $forumCategoryName . '/' . $forumSubcategoryName . '/' . $forumQuestion->id . '-' . mb_strtolower(str_replace(' ', '-', $forumQuestion->theme)));
                }
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
