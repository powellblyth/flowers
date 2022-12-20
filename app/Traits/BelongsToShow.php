<?php

namespace App\Traits;

use App\Models\Show;
use  Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToShow
{

    /****   Scopes   ****/
    public function scopeForShow(Builder $query, Show $show): Builder
    {
        return $query->where($this->getTable() . '.show_id', $show->id);
    }

    /****   Relations   ****/
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
}
