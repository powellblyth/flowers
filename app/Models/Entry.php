<?php

namespace App\Models;

use App\Traits\BelongsToCategory;
use App\Traits\BelongsToShow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Entry
 *
 * @property int $id
 * @property int $category_id
 * @property int $entrant_id
 * @property int $paid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $winningplace
 * @property int|null $year
 * @property int|null $show_id
 * @property-read Category $category
 * @property-read Entrant $entrant
 * @property-read Show|null $show
 * @method static Builder|Entry newModelQuery()
 * @method static Builder|Entry newQuery()
 * @method static Builder|Entry query()
 * @method static Builder|Entry whereCategoryId($value)
 * @method static Builder|Entry whereCreatedAt($value)
 * @method static Builder|Entry whereEntrantId($value)
 * @method static Builder|Entry whereId($value)
 * @method static Builder|Entry wherePaid($value)
 * @method static Builder|Entry whereShowId($value)
 * @method static Builder|Entry whereUpdatedAt($value)
 * @method static Builder|Entry whereWinningplace($value)
 * @method static Builder|Entry whereYear($value)
 * @method static Builder|Entry forShow(\App\Models\Show $show)
 * @mixin \Eloquent
 */
class Entry extends Model
{
    use BelongsToShow;
    use BelongsToCategory;

    public $fillable = [
        'entrant_id',
        'show_id',
        'category_id',
    ];

    public function winningLabel(): Attribute
    {
        return new Attribute(
            get: fn($value) => match ((string) $this->winningplace) {
                '1' => 'First Place',
                '2' => 'Second Place',
                '3' => 'Third Place',
                default => ucwords($this->winningplace)
            }
        );
    }

    public function winningColour($default = '#d9edf7'): Attribute
    {
        return new Attribute(
            get: fn($value) => match ($this->winningplace) {
                '1' => '#c00',
                '2' => '#00c',
                '3' => '#FF0',
                default => null
            }
        );
    }

    public function precedenceSorter(): Attribute
    {
        return new Attribute(
            get: fn($value) => match ($this->winningplace) {
                '1', '2', '3' => (int)$this->winningplace,
                'commended' => 4,
                default => 5
            }
        );
    }

    public function hasWon(): bool
    {
        return !empty(trim($this->winningplace));
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function getPlacementName(): string
    {
        return match ((string) $this->winningplace) {
            '1' => 'First Place',
            '2' => 'Second Place',
            '3' => 'Third Place',
            default => ucwords($this->winningplace),
        };
    }

    /**
     * @throws \Exception
     */
    public function getPriceType(): string
    {
        if ($this->isLate()) {
            return Category::PRICE_LATE_PRICE;
        } else {
            return Category::PRICE_EARLY_PRICE;
        }
    }

    /**
     * @throws \Exception
     */
    public function isLate(): bool
    {
        $created = new \DateTime($this->created_at);

        $cutoffDate = new \DateTime($this->show->late_entry_deadline);

        return $created > $cutoffDate;
    }

    public function getCardBackData(): array
    {
        return [
            'class_number' => $this->category->number,
            'class_name' => $this->category->name,
            'entrant_name' => $this->entrant->full_name,
            'entrant_number' => $this->entrant->entrant_number,
            'entrant_age' => $this->entrant->age_description,
            'user_sort_letter' => strtoupper(substr($this->entrant->user->last_name, 0, 1)),
        ];
    }

    public function getCardFrontData(): array
    {
        return ['class_number' => $this->category->number,
                'entrant_number' => $this->entrant->entrant_number,
                'entrant_age' => $this->entrant->age_description,
        ];
    }

    public function getActualPrice(): float
    {
        return $this->category->getPrice($this->getPriceType());
    }
}
