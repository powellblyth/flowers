<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getYearFromRequest(Request $request): int
    {
        if ($request->filled('year')
            && is_numeric($request->year)
            && (int) $request->year > 2015
            && (int) $request->year < (int) date('Y')) {
            return (int) $request->year;
        } else {
            return config('app.year');
        }
    }

    protected function getShowFromRequest(Request $request): Show
    {
        if ($request->filled('show_id')) {
            return Show::findOrFail((int) $request->show_id);
        } else {
            return Show::where('status', 'current')
                ->first();
        }
    }


}
