<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ShowsController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Team::class, 'team');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $show = $this->getShowFromRequest($request);

        $this->authorize('viewAny', Show::class);
        $shows = Show::get();
        return response()->view('shows.index', ['shows' => $shows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Show::class);
        return response()->view('shows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Show::class);
        $request->validate(
            [
                'name'    => 'string|required',
                'min_age' => 'integer|min:0|',
                'max_age' => 'integer|min:' . (int) $request->min_age,
            ]
        );

        $show          = new Show();
        $show->name    = $request->name;
        $show->min_age = $request->min_age;
        $show->max_age = $request->max_age;
        $show->save();
        return response()->redirectTo(route('shows.show', ['show' => $show->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Show $show)
    {
        $this->authorize('view', Show::class);
        return response()->view('shows.show', ['show' => $show]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Show $show)
    {
        $this->authorize('update', Show::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Show $show)
    {
        $this->authorize('update', Show::class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Show $show)
    {
        $this->authorize('delete', Show::class);
    }

    public function duplicate(Show $show)
    {
        $this->authorize('create', Show::class);
        return response()->view('shows.duplicate', ['show' => $show]);
    }
}
