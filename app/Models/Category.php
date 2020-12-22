<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property float late_price
 * @property float price
 * @method static Builder where(string $string, mixed $id, mixed $otherParam)
 * @property int id
 */
class Category extends Model
{

    const TYPE_JUNIOR       = 'Junior';
    const TYPE_ADULT        = 'Adult';
    const PRICE_LATE_PRICE  = 'lateprice';
    const PRICE_EARLY_PRICE = 'earlyprice';


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

    public function getUrl()
    {
        return '/categories/' . $this->id;
    }

    public function __toString(): string
    {
        return $this->getNumberedLabel();
    }

    public function getWinningAmount(string $placement)
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

    public function getType()
    {
        if (in_array($this->section->number, ['8', '9'])) {
            $type = self::TYPE_JUNIOR;
        } else {
            $type = self::TYPE_ADULT;
        }
        return $type;
    }

    public function getPrice(string $type)
    {
        if ($type === self::PRICE_EARLY_PRICE) {
            return $this->price;
        } else {
            return $this->late_price;
        }
    }

}
