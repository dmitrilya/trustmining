<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

use App\Services\Insight\Content\ArticleService;
use App\Services\RouletteSpinService;

use App\Models\Roulette\RoulettePrize;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        view()->share('popularArticle', (new ArticleService())->getPopular('article', 1, '1 week')->first());
        view()->share('roulettePrizes', RoulettePrize::whereNotNull('activated_at')->whereNull('deactivated_at')
            ->select(['id', 'user_id', 'name', 'caption', 'partner_link', 'chance'])->with(['user:id,name', 'user.company:user_id,logo'])
            ->inRandomOrder()->get());
        view()->share('timeToSpin', (new RouletteSpinService)->timeToSpin());

        return view('layouts.app');
    }
}
