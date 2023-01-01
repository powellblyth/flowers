<?php

namespace App\Traits\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

trait HasShowSwitcher
{

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
