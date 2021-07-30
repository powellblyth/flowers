<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Entry
 *
 * @property int $id
 * @property int $category_id
 * @property int $entrant_id
 * @property int $paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $winningplace
 * @property int|null $year
 * @property int|null $show_id
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Entrant $entrant
 * @property-read \App\Models\Show|null $show
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry query()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereEntrantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereWinningplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereYear($value)
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
        switch ($this->winningplace)
        {
            case '1':return 'First Place'; break;
            case '2':return 'Second Place';break;
            case '3':return 'Third Place';break;
            default :return ucwords($this->winningplace);break;
        };
        return $result;
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
            'entrant_name' => $this->entrant->getName(),
            'entrant_number' => $this->entrant->getEntrantNumber(),
            'entrant_age' => (($this->entrant->age && 18 > (int) $this->entrant->age)
                ? $this->entrant->age
                : ''),
            'user_sort_letter' => strtoupper(substr($this->entrant->user->lastname, 0, 1)),
        ];
    }

    public function getCardFrontData(): array
    {
        return ['class_number' => $this->category->number,
                'entrant_number' => $this->entrant->getEntrantNumber(),
                'entrant_age' => (($this->entrant->age && 18 > (int) $this->entrant->age)
                    ? $this->entrant->age
                    : ''),
        ];
    }

    public function getActualPrice(): float
    {
        return $this->category->getPrice($this->getPriceType());
    }
}
