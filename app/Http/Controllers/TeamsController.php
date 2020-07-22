<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TeamsController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Team::class, 'team');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $show = $this->getShowFromRequest($request);

        if (Auth::user() && Auth::user()->can('viewAny', Team::class)) {
            $teams = Team::with('team_memberships.entrant')->get();
        } else {
            $teams = Team::with('team_memberships.entrant')
                ->where('status', Team::STATUS_ACTIVE)
                ->orderBy('name')->get();
        }
        return response()->view('teams.index', ['teams' => $teams, 'show_id'=>$show->id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Team::class);
        return response()->view('teams.create');
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
        $this->authorize('update', Team::class);
        $request->validate(
            [
                'name'    => 'string|required',
                'min_age' => 'integer|min:0|',
                'max_age' => 'integer|min:' . (int) $request->min_age,
            ]
        );

        $team          = new Team();
        $team->name    = $request->name;
        $team->min_age = $request->min_age;
        $team->max_age = $request->max_age;
        $team->save();
        return response()->redirectTo(route('teams.show', ['team' => $team->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Team $team)
    {
        $this->authorize('view', Team::class);
        return response()->view('teams.show', ['team' => $team]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Team $team)
    {
        $this->authorize('update', Team::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Team $team
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Team $team)
    {
        $this->authorize('update', Team::class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Team $team)
    {
        $this->authorize('delete', Team::class);
    }
}
