<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Section
 * @package App\Models
 * @property string number
 * @property string name
 * @property string judges
 * @property string image
 */
class Section extends Model
{
    public function getDisplayNameAttribute(): string
    {
        return $this->number . ' - ' . $this->name;
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
