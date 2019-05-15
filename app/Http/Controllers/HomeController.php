<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index($extraData = [])
    {

        $entrantCount = Auth::User()->entrants()->count();
        return view('dashboard', ['entrantCount'=>$entrantCount]);
    }
}
