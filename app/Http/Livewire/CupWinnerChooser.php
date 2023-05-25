<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Cup;
use App\Models\Entrant;
use App\Models\Show;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class CupWinnerChooser extends Component
{
    public Cup $cup;
    /** @var Collection<Category> */
    public Collection $categories;
    public ?int $category_id = null;
    public ?Show $show;
    /** @var Collection<Entrant>|null */
    public ?Collection $entries =null;

    public function render(): Factory|View|Application
    {
        if ($this->category_id) {
            $category = Category::with('entries', 'entries.entrant')->findOrFail($this->category_id);
            $this->entries = $category->entries;
        }
        return view('livewire.cup-winner-chooser');
    }
}
