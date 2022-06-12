<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavButton extends Component
{
    public bool $hidden = true;

    public function render()
    {
        return view('livewire.nav-button');
    }

    public function toggle(): bool
    {
        $this->hidden = !$this->hidden;
        return $this->hidden;
    }

    public function hide()
    {
        $this->hidden = true;
    }
}
