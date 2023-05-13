<?php

namespace App\Http\Controllers;

use App\Models\RaffleDonor;
use App\Models\RafflePrize;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RaffleController extends Controller
{
    use HasShowSwitcher;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response|View
    {
        $show = $this->getShowFromRequest($request);

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
