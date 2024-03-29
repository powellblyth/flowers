<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamsController extends Controller
{
    use HasShowSwitcher;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request): Response
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
    public function show(Team $team): Response
    {
        $this->authorize('view', Team::class);
        return response()->view('teams.show', ['team' => $team]);
    }

}
