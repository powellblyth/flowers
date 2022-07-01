<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class JudgeRole
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class JudgeRole extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/

    public function judges(): HasMany
    {
        return $this->hasMany(Judge::class);
    }

    public function shows(): BelongsToMany
    {
        return $this->belongsToMany(Show::class)
            ->withPivot('judge_role')
            ->withTimestamps();
    }

    public function sections(): BelongsToMany
    {
        return $this->BelongsToMany(Section::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(Category::class);
    }
    public function cups(): BelongsToMany
    {
        return $this->BelongsToMany(Cup::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
