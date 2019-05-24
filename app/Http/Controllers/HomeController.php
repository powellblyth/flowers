<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use \Illuminate\View\View;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(array $extraData = []): View {
        $totalEntries = 0;
        $entrantCount = Auth::User()->entrants()->count();
        foreach (Auth::User()->entrants as $entrant) {
            $totalEntries += $entrant->entries()->count();
        }

        return view('dashboard', ['entrantCount' => $entrantCount, 'entryCount' => $totalEntries]);
    }
}
