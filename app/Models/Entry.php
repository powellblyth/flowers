<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Entry
 * @package App
 * @property Entrant $entrant
 * @property Show show
 */
class Entry extends Model
{

    public function hasWon()
    {
        return !empty(trim($this->winningplace));
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPlacementName()
    {
        $result = 0;
        switch ($this->winningplace) {
            case '1':
                $result = 'First Place';
                break;
            case '2':
                $result = 'Second Place';
                break;
            case '3':
                $result = 'Third Place';
                break;
            default:
                $result = ucwords($this->winningplace);
                break;
        }
        return $result;
    }

    public function getPriceType(): string
    {
        if ($this->isLate()) {
            return Category::PRICE_LATE_PRICE;
        } else {
            return Category::PRICE_EARLY_PRICE;
        }
    }

    /**
     * @return bool
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
            'class_number'     => $this->category->number,
            'class_name'       => $this->category->name,
            'entrant_name'     => $this->entrant->getName(),
            'entrant_number'   => $this->entrant->getEntrantNumber(),
            'entrant_age'      => (($this->entrant->age && 18 > (int) $this->entrant->age) ? $this->entrant->age : ''),
            'user_sort_letter' => strtoupper(substr($this->entrant->user->lastname, 0, 1)),
        ];
    }

    public function getCardFrontData(): array
    {
        return ['class_number'   => $this->category->number,
                'entrant_number' => $this->entrant->getEntrantNumber(),
                'entrant_age'    => (($this->entrant->age && 18 > (int) $this->entrant->age) ? $this->entrant->age : ''),
        ];
    }

    public function getActualPrice()
    {
        return $this->category->getPrice($this->getPriceType());
    }

}
