<?php

namespace App\Http\Controllers;

use App\Models\RaffleDonor;
use App\Models\RafflePrize;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    use HasShowSwitcher;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $show = $this->getShowFromRequest($request);

//        $don

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\RaffleDonor $raffleDonor
     * @return \Illuminate\Http\Response
     */
    public function show(RaffleDonor $raffleDonor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\RaffleDonor $raffleDonor
     * @return \Illuminate\Http\Response
     */
    public function edit(RaffleDonor $raffleDonor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RaffleDonor $raffleDonor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RaffleDonor $raffleDonor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\RaffleDonor $raffleDonor
     * @return \Illuminate\Http\Response
     */
    public function destroy(RaffleDonor $raffleDonor)
    {
        //
    }
}
