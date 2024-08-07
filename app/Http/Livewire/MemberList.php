<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class MemberList extends Component
{
    public Collection $memberList;

    public ?string $filter = null;


    public function render(): Factory|View|Application
    {
        // TODOD this
//        does not search properly
        $memberSearch = User::with('membershipPurchases')->notanonymised()->alphabetical();
        if ($this->filter) {
            $memberSearch = $memberSearch->where('last_name', 'LIKE', '%' . $this->filter . '%')
                ->orWhere('first_name', 'LIKE', '%' . $this->filter . '%')
                ->orWhere('email', 'LIKE', '%' . $this->filter . '%')
                ->orWhere('id', '=', $this->filter)
                ->orWhere('postcode', 'LIKE', '%' . $this->filter . '%')
                ->orWhere('address_1', 'LIKE', '%' . $this->filter . '%')
                ->orWhere('address_2', 'LIKE', '%' . $this->filter . '%');
        }

        $this->memberList = $memberSearch->get();
        return view('livewire.member-list');
    }
}
