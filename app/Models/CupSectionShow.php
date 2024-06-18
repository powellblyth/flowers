<?php

namespace App\Models;

use App\Traits\BelongsToSection;
use App\Traits\BelongsToShow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Cup
 *
 */
class CupSectionShow extends Model
{
    use BelongsToShow;
    use BelongsToSection;

    public $table = 'cup_section_show';

    public function cup(): BelongsTo
    {
        return $this->belongsTo(Cup::class);
    }
}
