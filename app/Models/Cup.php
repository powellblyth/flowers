<?php

namespace App\Models;

use App\Services\CupCalculatorService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
 * @mixin \Eloquent
 * @property-read bool $is_points_based
 */
class Cup extends Model
{
    final public const WINNING_BASIS_TOTAL_POINTS = 'total_points';
    final public const WINNING_BASIS_JUDGES_CHOICE = 'judges_choice';


    public function isPointsBased(): Attribute
    {
        return new Attribute(
            get: fn($value): bool => $this->winning_basis === self::WINNING_BASIS_TOTAL_POINTS
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function relatedCategories(Show $show): Collection
    {
        if ($this->section !== null) {
            return $this
                ->section
                ->categories()
                ->orderBy('sortorder')
                ->forShow($show)
                ->get();
        } else {
            return $this->categories()
                ->orderBy('sortorder')
                ->forShow($show)
                ->get();
        }
    }

    public function judgeRoles(): BelongsToMany
    {
        return $this->belongsToMany(JudgeRole::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function cupDirectWinner(): HasMany
    {
        return $this->hasMany(CupDirectWinner::class);
    }

    /**
     * This represents the judges choice on the day. This will get codified into a
     * CupWinnerArchive in the future
     */
    public function cupWinnerArchive(): HasMany
    {
        return $this->hasMany(CupWinnerArchive::class);
    }

    /**
     * creates or returns the cup winner archive
     */
    public function getWinnerArchiveForShow(Show $show): CupWinnerArchive
    {
        return $this->cupWinnerArchive()
            ->forShow($show)
            ->firstOrNew(
                [
                    'cup_id' => $this->id,
                    'show_id' => $show->id,
                ]
            );
    }

    public function getJudgesForThisShow(Show $show, string $prefix = ''): ?string
    {
        // TODO this should be a model call not a display call
        $judges = $this
            ->judgeRoles
            // this is good, all the judge roles for the cups
            // NEXT we need to       bring in all the JudgeAtShow for that role, for that show

            ->reduce(function (\Illuminate\Support\Collection $carry, \App\Models\JudgeRole $judgeRole) use ($show) {
//   echo($judgeRole->judgesForShow($show));die();
//var_dump(($judgeRole->label));die();
                return $carry->merge($judgeRole->judgesForShow($show)->get());
            },
                new \Illuminate\Support\Collection())
            ->reduce(function (array $carry, \App\Models\Judge $judge) {
                $carry[] = $judge->name;
                return $carry;
            }, []);
        if (empty($judges)) {
            return '';
        }

        return $prefix . ' ' . implode(', ', $judges);
    }

    public function getWinnersForShow(Show $show): CupWinnerArchive
    {
        $service = new CupCalculatorService($show, $this);
        //TODO this is a little inefficient
        $winnerArchive = $this->getWinnerArchiveForShow($show);
        // If the show has passed, then we can stop foofing about with the calculations
        // we don't know if the rules changed over the years, so we can't risk recalculating
        // However, if there isn't one, we go ahead and calculate it.
        // this will go in the bin once all historics are generated
        if (!$winnerArchive->exists || $show->isCurrent()) {
            if ($this->is_points_based) {
                $winnerArchive = $service->recalculateWinnerFromPoints();
            } else {
                $winnerArchive = $service->recalculateWinnerFromJudgeNotes();
            }
        }
        return $winnerArchive;
    }


    public function getValidCategoryIdsForShow(Show $show): array
    {
        if ($this->section_id) {
            return $this->section->categories()->forShow($show)->pluck('id')->toArray();
        } else {
            return $this->relatedCategories($show)->pluck('id')->toArray();
        }
    }

    public static function getWinningBasisOptions(): array
    {
        return [
            Cup::WINNING_BASIS_TOTAL_POINTS => 'Highest Points',
            Cup::WINNING_BASIS_JUDGES_CHOICE => 'Judge\'s Choice',
        ];
    }

    public function getWinningResultsAdmin(Show $show)
    {
        /**
         * @TODO This was only collected for temporary
         */
        $categoryIds = $this->getValidCategoryIdsForShow($show);
        return DB::select(
            "
            select sum(if(winningplace='1', 4,0)) as first_place_points, 
                sum(if(winningplace='2', 3,0) ) as second_place_points, 
                sum(if(winningplace='3', 2,0)) as third_place_points, 
                sum(if(winningplace='commended', 1,0)) as commended_points, 
                sum(
                    if(winningplace='1', 4,0) 
                        + if(winningplace='2', 3,0) 
                        + if(winningplace='3', 2,0) 
                        + if(winningplace='commended', 1,0)
                    ) as total_points,
                entrant_id 
            
            from entries 
            
            where 
                category_id in (" . implode(',', $categoryIds) . ")
                AND entries.show_id = ?
            
            group by entrant_id
            
            having (total_points > 0)
            order by (total_points) desc
",
            array($show->id)
        );
    }

}
