<?php

namespace App\Models;

use App\Traits\BelongsToShow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class JudgeAtShow
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $judge_id
 * @property int $judge_role_id
 * @property int $show_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Judge|null $judge
 * @property-read \App\Models\JudgeRole|null $judgeRole
 * @property-read \App\Models\Show|null $show
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow query()
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow whereJudgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow whereJudgeRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeAtShow forShow(\App\Models\Show $show)
 */
class JudgeAtShow extends Model
{
    use HasFactory;
    use BelongsToShow;

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
