<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class HomeLayout extends Component
{
    public function __construct(public array $data = []) {}

    public function render(): View
    {
        return view('layouts.home', $this->data);
    }
}
