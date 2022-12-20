<?php

namespace App\Models;

use App\Traits\BelongsToShow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class JudgeAtShow
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $judge_id
 * @property int $judge_role_id
 * @property int $show_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Judge|null $judge
 * @property-read JudgeRole|null $judgeRole
 * @property-read Show|null $show
 * @method static Builder|JudgeAtShow newModelQuery()
 * @method static Builder|JudgeAtShow newQuery()
 * @method static Builder|JudgeAtShow query()
 * @method static Builder|JudgeAtShow whereCreatedAt($value)
 * @method static Builder|JudgeAtShow whereId($value)
 * @method static Builder|JudgeAtShow whereJudgeId($value)
 * @method static Builder|JudgeAtShow whereJudgeRoleId($value)
 * @method static Builder|JudgeAtShow whereShowId($value)
 * @method static Builder|JudgeAtShow whereUpdatedAt($value)
 * @method static Builder|JudgeAtShow forShow(Show $show)
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

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
