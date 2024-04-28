<?php

namespace App\Traits;

use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCategory
{

    /****   Scopes   ****/
    public function scopeForCategory(Builder $query, Category $category): Builder
    {
        return $query->where($this->getTable() . '.category_id', $category->id);
    }

    /****   Relations   ****/
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
