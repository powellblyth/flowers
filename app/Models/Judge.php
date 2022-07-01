<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;

/**
 * Class Judge
 *
 * @package App\Models
 * @mixin Model
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $cv
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Judge newModelQuery()
 * @method static Builder|Judge newQuery()
 * @method static Builder|Judge query()
 * @method static Builder|Judge whereCreatedAt($value)
 * @method static Builder|Judge whereCv($value)
 * @method static Builder|Judge whereDescription($value)
 * @method static Builder|Judge whereId($value)
 * @method static Builder|Judge whereName($value)
 * @method static Builder|Judge whereUpdatedAt($value)
 */
class Judge extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/
    public function judgeAtShow(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JudgeAtShow::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
