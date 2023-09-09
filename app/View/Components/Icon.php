<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Icon extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public string $prefix = 'fa-solid'
    ) {
        $this->name = $name;
        $this->prefix = $prefix;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.icon');
    }
}
