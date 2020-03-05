<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Card extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.card');
    }
}
