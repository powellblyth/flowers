<?php

namespace App\Models;

use App\Traits\BelongsToSection;
use App\Traits\BelongsToShow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cup
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $calculated_winner
 * @property string|null $winning_criteria
 * @property int|null $sort_order
 * @property int|null $num_display_results
 * @property int|null $section_id
 * @property string $winning_basis
 * @property string|null $judges_notes
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|CupDirectWinner[] $cupDirectWinner
 * @property-read int|null $cup_direct_winner_count
 * @property-read Collection|CupWinnerArchive[] $cupWinnerArchive
 * @property-read int|null $cup_winner_archive_count
 * @property-read Collection|JudgeRole[] $judgeRoles
 * @property-read int|null $judge_roles_count
 * @property-read Section|null $section
 * @method static Builder|Cup newModelQuery()
 * @method static Builder|Cup newQuery()
 * @method static Builder|Cup query()
 * @method static Builder|Cup whereCalculatedWinner($value)
 * @method static Builder|Cup whereCreatedAt($value)
 * @method static Builder|Cup whereId($value)
 * @method static Builder|Cup whereJudgesNotes($value)
 * @method static Builder|Cup whereName($value)
 * @method static Builder|Cup whereNumDisplayResults($value)
 * @method static Builder|Cup whereSectionId($value)
 * @method static Builder|Cup whereSortOrder($value)
 * @method static Builder|Cup whereUpdatedAt($value)
 * @method static Builder|Cup whereWinningBasis($value)
 * @method static Builder|Cup whereWinningCriteria($value)
 * @property-read bool $is_points_based
 * @method static Builder|Cup inOrder()
 * @mixin \Eloquent
 */
class CupSectionShow extends Model
{
    use BelongsToShow;
    use BelongsToSection;

    public function cup(): BelongsTo
    {
        return $this->belongsTo(Cup::class);
    }
}
