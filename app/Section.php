<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
    //
}
