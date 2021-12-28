<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $number
 * @property int $price
 * @property int $late_price
 * @property int $sortorder
 * @property int|null $first_prize
 * @property int|null $second_prize
 * @property int|null $third_prize
 * @property int|null $year
 * @property int|null $show_id
 * @property int|null $section_id
 * @property string $status
 * @property int|null $cloned_from
 * @property string|null $deleted_at
 * @property-read Collection|Cup[] $cups
 * @property-read int|null $cups_count
 * @property-read Collection|Entry[] $entries
 * @property-read int|null $entries_count
 * @property-read string $numbered_name
 * @property-read \App\Models\Section|null $section
 * @property-read \App\Models\Show|null $show
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereClonedFrom($value)
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDeletedAt($value)
 * @method static Builder|Category whereFirstPrize($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereLatePrice($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereNumber($value)
 * @method static Builder|Category wherePrice($value)
 * @method static Builder|Category whereSecondPrize($value)
 * @method static Builder|Category whereSectionId($value)
 * @method static Builder|Category whereShowId($value)
 * @method static Builder|Category whereSortorder($value)
 * @method static Builder|Category whereStatus($value)
 * @method static Builder|Category whereThirdPrize($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereYear($value)
 * @mixin \Eloquent
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

    public function numberedName(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->number . '. ' . $this->name
        );
    }

    public function __toString(): string
    {
        return (string) $this->numbered_name;
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
