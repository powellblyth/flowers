<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @mixin \Eloquent
 */
class Entry extends Model
{

    public $fillable = [
        'entrant_id',
        'show_id',
        'category_id',
    ];

    public function hasWon(): bool
    {
        return !empty(trim($this->winningplace));
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPlacementName(): string
    {
        $result = 0;
        return match ($this->winningplace) {
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
