<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Section
 * @package App\Models
 * @property int id
 */
class Section extends Model
{
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
