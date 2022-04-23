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

    /**
     * @param Request $request
     * @param array $extraRelations
     * @return Show
     */
    protected function getShowFromRequest(Request $request, array $extraRelations = []): Show
    {
        $builder = Show::with(array_merge(['categories'], $extraRelations));
        if ($request->filled('show_id')) {
            return $builder->findOrFail((int) $request->get('show_id'));
        }

        if ($request->filled('show')) {
            return $builder
                ->findOrFail((int) $request->get('show'));
        }

        return $builder
            ->where('status', Show::STATUS_CURRENT)
            ->orderBy('start_date', 'DESC')
            ->first();
    }

}
