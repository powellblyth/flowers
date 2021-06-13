<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Entry
 * @package App
 * @property Entrant $entrant
 * @property Show $show
 * @property string $winningplace
 * @property Category $category
 * @property int $category_id
 * @property int $entrant_id
 * @property int $year
 */
class Entry extends Model
{

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
        $result = match ($this->winningplace) {
            '1' => 'First Place',
            '2' => 'Second Place',
            '3' => 'Third Place',
            default => ucwords($this->winningplace),
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
