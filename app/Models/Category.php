<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property float late_price
 * @property float price
 * @property Collection cups
 * @property string number
 * @property string name
 * @property Section section
 * @property int first_prize
 * @property int second_prize
 * @property int third_prize
 * @property Show show
 */
class Category extends Model implements \Stringable
{

    public const TYPE_JUNIOR = 'Junior';
    public const TYPE_ADULT = 'Adult';
    public const PRICE_LATE_PRICE = 'lateprice';
    public const PRICE_EARLY_PRICE = 'earlyprice';

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function cups(): BelongsToMany
    {
        return $this->belongsToMany(Cup::class);
    }

    public function getNumberedNameAttribute(): string
    {
        return $this->getNumberedLabel();
    }

    public function __toString(): string
    {
        return $this->getNumberedLabel();
    }

    public function getWinningAmount(string $placement): int
    {
        $result = 0;
        if ('1' == $placement) {
            $result = $this->first_prize;
        } elseif ('2' == $placement) {
            $result = $this->second_prize;
        } elseif ('3' == $placement) {
            $result = $this->third_prize;
        }
        return $result;
    }

    public function getNumberedLabel(): string
    {
        return $this->number . '. ' . $this->name;
    }

    public function getType(): string
    {
        if (in_array($this->section->number, ['8', '9'])) {
            $type = Category::TYPE_JUNIOR;
        } else {
            $type = Category::TYPE_ADULT;
        }
        return $type;
    }

    public function getPrice(string $type): float
    {
        if ($type === Category::PRICE_EARLY_PRICE) {
            return $this->price;
        } else {
            return $this->late_price;
        }
    }

}
