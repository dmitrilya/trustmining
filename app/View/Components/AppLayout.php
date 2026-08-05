<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

use App\Services\Insight\Content\ArticleService;
use App\Services\RouletteService;

use App\Models\Roulette\RoulettePrize;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        view()->share('popularArticle', (new ArticleService())->getPopular('article', 1, '1 week')->first());
        view()->share('roulettePrizes', (new RouletteService)->getPrizes());
        view()->share('timeToSpin', (new RouletteService)->timeToSpin());

        return view('layouts.app');
    }
}
