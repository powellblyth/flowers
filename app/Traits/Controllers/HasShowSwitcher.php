<?php

namespace App\Traits\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

trait HasShowSwitcher
{

    protected function getShowFromRequest(Request $request, array $extraRelations = []): Show
    {
        $builder = Show::with(array_merge(['categories'], $extraRelations));
        if ($request->filled('show_id') || $request->filled('show')) {
            return $builder->findOrFail((int) $request->get('show_id') ?? $request->get('show'));
        }
        return $builder
            ->where('status', Show::STATUS_CURRENT)
            ->newestFirst()
            ->first();
    }

    protected function getMostRecentShow(array $extraRelations = []): Show
    {
        return Show::with(array_merge(['categories'], $extraRelations))
            ->current()
            ->latestFirst()
            ->first();
    }
}
