<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $show = $this->getShowFromRequest($request);

            $teams = Team::with('teams.entrant')
                ->where('status', Team::STATUS_ACTIVE)
                ->orderBy('name')->get();
        return response()->view('teams.index', ['teams' => $teams, 'show_id' => $show->id]);
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Team $team)
    {
        $this->authorize('view', Team::class);
        return response()->view('teams.show', ['team' => $team]);
    }

}
