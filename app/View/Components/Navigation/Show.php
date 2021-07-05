<?php

namespace App\View\Components\Navigation;

use Illuminate\View\Component;

class Show extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?\App\Models\Show $show = null, public string $route='cups.index')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navigation.show', [
            'shows' => \App\Models\Show::orderBy('start_date')->get(),
            'route' => $this->route,
            'show' => $this->show,
        ]);
    }
}
