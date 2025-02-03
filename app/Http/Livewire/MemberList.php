<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
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
        $filter = trim($this->filter);
        // TODOD this
//        does not search properly
        $memberSearch = User::with('membershipPurchases')->notanonymised()->alphabetical();
        if ($this->filter) {
            $memberSearch = $memberSearch->where(fn(Builder $query) => $query->where('last_name', 'LIKE', '%' . $filter . '%')
                ->orWhere('first_name', 'LIKE', '%' . $filter . '%')
                ->orWhereRaw('concat_ws(\' \', first_name, last_name) like ? ', ['%' . $filter . '%'])
                ->orWhere('email', 'LIKE', '%' . $filter . '%')
                ->orWhere('id', '=', $filter)
                ->orWhere('postcode', 'LIKE', '%' . $filter . '%')
                ->orWhere('address_1', 'LIKE', '%' . $filter . '%')
                ->orWhere('address_2', 'LIKE', '%' . $this->filter . '%')
            );
        }

        $this->memberList = $memberSearch->get();
        return view('livewire.member-list');
    }
}
