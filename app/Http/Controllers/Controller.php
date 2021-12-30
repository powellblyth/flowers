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

    protected function getShowFromRequest(Request $request): Show
    {
        if ($request->filled('show_id')) {
            $show = Show::with('categories')->findOrFail((int) $request->show_id);
        } elseif ($request->filled('show')) {
            $show = Show::with('categories')->findOrFail((int) $request->show);
        } else {
            $show = Show::with('categories')->where('status', 'current')
                ->first();
        }
        return $show;
    }


}
