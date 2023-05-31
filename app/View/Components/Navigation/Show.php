<?php

namespace App\View\Components\Navigation;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Show extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?\App\Models\Show $show = null, public string $route = 'cups.index')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|View|string
    {
        return view('components.navigation.show', [
            'shows' => \App\Models\Show::public()
                ->newestFirst()
                ->get()
                ,
            'route' => $this->route,
            'show' => $this->show,
        ]);
    }
}
