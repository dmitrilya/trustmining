<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

use App\Services\Insight\Content\ArticleService;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        view()->share('popularArticle', (new ArticleService())->getPopular('article', 1, '1 week')->first());

        return view('layouts.app');
    }
}
