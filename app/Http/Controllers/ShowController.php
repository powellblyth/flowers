<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowController extends Controller
{
    use HasShowSwitcher;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
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
    public function statusReport(Request $request, Show $show): Response
    {
        $this->authorize('viewAny', $show);
        return response()->view(
            'shows.showStatus',
            [
                'show' => $show,
            ]
        );
    }
}
