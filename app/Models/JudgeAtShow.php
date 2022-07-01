<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class JudgeAtShow
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class JudgeAtShow extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'judge_show';

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function judge(): BelongsTo
    {
        return $this->belongsTo(Judge::class);
    }

    public function judgeRole(): BelongsTo
    {
        return $this->belongsTo(JudgeRole::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
