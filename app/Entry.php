<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{

    public function hasWon()
    {
        return !empty(trim($this->winningplace));
    }

    public function getPlacementName()
    {
        $result = 0;
        if ('1' === $this->winningplace) {
            $result = 'First Place';
        } elseif ('2' === $this->winningplace) {
            $result = 'Second Place';
        } elseif ('3' === $this->winningplace) {
            $result = 'Third Place';
        } else {
            $result = ucwords($this->winningplace);
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

        $cutoffDate = new \DateTime($this->getCutoffDate($this->year));

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
//        die(var_dump([$this->getPriceType(),$this->category->getPrice($this->getPriceType()) ]));
        return $this->category->getPrice($this->getPriceType());
    }

    public function getCutoffDate(int $year): string
    {
        $date = '';
        switch ($year) {
            case 2019:
                $date = '3 July 2019 23:59:59';
                break;
            case 2018:
                $date = '4 July 2018 23:59:59';
                break;
            case 2017:
            default:
                $date = '6 July 2017 12:00:59';
        }
        return $date;
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
