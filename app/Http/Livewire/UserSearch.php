<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class UserSearch extends Component
{
    public User $existingUser;
    public ?Collection $results;
    public ?string $firstName = 'a';
    public ?string $familyName = '';

    public function render()
    {
        return view('livewire.user-search');
    }
    public function mount(User $existingUser)
    {
        $this->existingUser = $existingUser;
        $this->doSearch();
    }
    public function doSearch()
    {
        $this->results = User::where('first_name', 'like', '%' . $this->firstName . '%')
            ->where('last_name', 'like', '%' . $this->familyName . '%')
            ->notAnonymised()
            ->where('id', '<>', $this->existingUser->id)
            ->get();
    }
}
