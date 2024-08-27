<?php

namespace App\Traits;

use App\Models\Section;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSection
{

    /****   Scopes   ****/
    public function scopeForSection(Builder $query, Section $section): Builder
    {
        return $query->where($this->getTable() . '.category_id', $section->id);
    }

    /****   Relations   ****/
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
