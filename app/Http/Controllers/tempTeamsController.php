<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class tempTeamsController extends Controller
{
    public function creates(Request $request)
    {
        $team          = new Team();
        $team->name    = (int) $request->input('entrant');
        $team->min_age = $request->input('age_from');
        $team->max_age = $request->input('age_to');
        $team->save();
        return redirect()->route('team.show', $team);
    }


    public function index(Request $request): View
    {
        $teams = Team::orderBy('age_from')->orderBy('age_to')->get();

        return view('teams.index', [
            'teams'   => $teams,
            'year'    => $this->getYearFromRequest($request),
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()
        ]);
    }

}
