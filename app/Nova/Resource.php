<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    /**
     * Build an "index" query for the given resource.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy')) && !empty(static::$sort)) {
            $query->getQuery()->orders = [];

            foreach (static::$sort as $column => $direction) {
                $query = $query->orderBy($column, $direction ?? 'asc');
            }
            return $query->orderBy(key(static::$sort), reset(static::$sort));
        }

        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param \Laravel\Scout\Builder $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }
}
