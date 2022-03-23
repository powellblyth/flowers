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

    protected function getShowFromRequest(Request $request, array $extraRelations = []): Show
    {
//        dump($extraRelations);
//        dd(array_merge(['categories'],$extraRelations));
        if ($request->filled('show_id')) {
            $show = Show::with(array_merge(['categories'],$extraRelations))->findOrFail((int) $request->show_id);
        } elseif ($request->filled('show')) {
            $show = Show::with(array_merge(['categories'],$extraRelations))->findOrFail((int) $request->show);
        } else {
            $show = Show::with(array_merge(['categories'],$extraRelations))->where('status', Show::STATUS_CURRENT)
                ->first();
        }
        return $show;
    }


}
