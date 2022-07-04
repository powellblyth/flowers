<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->getShowFromRequest($request);

        $this->authorize('viewAny', Show::class);
        $shows = Show::all();
        return response()->view('shows.index', ['shows' => $shows]);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Show $show): Response
    {
        $this->authorize('view', $show);
        return response()->view(
            'shows.show',
            [
                'show' => $show,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function statusReport(Request $request): Response
    {
        $show=  $this->getShowFromRequest($request);

        $this->authorize('viewAny', $show);
        return response()->view(
            'shows.showStatus',
            [
                'show' => $show,
            ]
        );
    }
}
