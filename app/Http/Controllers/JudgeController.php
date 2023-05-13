<?php

namespace App\Http\Controllers;

use App\Models\Judge;
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
    public function printSheets(Request $request): Application|Factory|View
    {
        /** @var Judge $judge */
        $judge = Judge::whereIn('id', $request->judges)->first();
        $show = $this->getShowFromRequest($request);

        return view('judges.printsheets', [
            'judge' => $judge,
            'show' => $show,
        ]);
    }
}
