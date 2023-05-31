<?php

namespace App\Http\Controllers;

use App\Models\RafflePrize;
use App\Models\Show;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class RaffleController extends Controller
{
    use HasShowSwitcher;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(Request $request): RedirectResponse
    {
        $show = $this->getShowFromRequest($request);
        return redirect(
            route('show.raffle', ['show' => $this->getShowFromRequest($request)]),
            301
        );
    }

    public function forShow(Request $request, ?Show $show)
    {
        $donors = RafflePrize::with('raffleDonor')
            ->whereBelongsTo($show)
            ->get()
            ->unique('raffleDonor')
            ->pluck('raffleDonor');
        return view(
            'raffle.index',
            [
                'donors' => $donors,
                'show' => $show,
            ]
        );
    }
}
