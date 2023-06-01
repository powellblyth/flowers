<?php

namespace App\Http\Controllers;

use App\Models\Judge;
use App\Models\Show;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class JudgeController extends Controller
{
    use HasShowSwitcher;

    /**
     * referenced by nova
     */
    public function printSheets(Request $request, Show $show, Judge $judge): Application|Factory|View
    {
        return view('judges.printsheets', [
            'judge' => $judge,
            'show' => $show,
        ]);
    }
}
