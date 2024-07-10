<?php

namespace App\Models;

use App\Traits\BelongsToShow;
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
 * @property-read Section|null $section
 * @property-read Show|null $show
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
 * @property int|null $minimum_age
 * @property int|null $maximum_age
 * @property bool $private private means you can't enter it as a member of the public, e.g.. school categories
 * @method static Builder|Category forShow(Show $show)
 * @method static Builder|Category inOrder()
 * @method static Builder|Category whereMaximumAge($value)
 * @method static Builder|Category whereMinimumAge($value)
 * @method static Builder|Category wherePrivate($value)
 * @property string $notes
 * @method static Builder|Category whereNotes($value)
 * @method static Builder|Category forSection(Section $section)
 * @property-read Collection|JudgeRole[] $judgeRoles
 * @property-read int|null $judge_roles_count
 * @mixin \Eloquent
 */
class Category extends Model implements \Stringable
{
    use BelongsToShow;

    public final const TYPE_JUNIOR = 'Junior';
    public final const TYPE_ADULT = 'Adult';
    public final const PRICE_LATE_PRICE = 'lateprice';
    public final const PRICE_EARLY_PRICE = 'earlyprice';

    public $casts = [
        'price' => 'int',
        'late_price' => 'int',
        'first_prize' => 'int',
        'second_prize' => 'int',
        'third_prize' => 'int',
        'minimum_age' => 'int',
        'maximum_age' => 'int',
        'private' => 'bool',
    ];

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $indexDefaultOrder = [
        'sortorder' => 'asc'
    ];

    public function scopeForSection(Builder $query, Section $section): Builder
    {
        return $query->where('section_id', $section->id);
    }

    public function scopeInOrder(Builder $query): Builder
    {
        return $query->orderby('categories.sortorder');
    }

    public function scopeExceptPrivate(Builder $query): Builder
    {
        return $query->where('private', false);
    }

    protected function numberedName(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->number . '. ' . $this->name
        );
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function judgeRoles(): BelongsToMany
    {
        return $this->belongsToMany(JudgeRole::class)->withTimestamps();
    }

    public function clonedFrom(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'cloned_from');
    }

    public function cups(): BelongsToMany
    {
        return $this->belongsToMany(Cup::class)->withTimestamps();
    }

    public function __toString(): string
    {
        return (string) $this->numbered_name;
    }

    public function incrementOrder($amount): static
    {
        $this->sortorder = $this->sortorder + $amount;
        // TODO this could handle categories like 103a better
        // Also toDO this could be a model method
        if (is_numeric($this->number)) {
            $this->number = $this->number + $amount;
        } else {
            $this->incrementNumberWithText($amount);
        }
        return $this;
    }

    public function incrementNumberWithText($amount)
    {
        $matches = null;
        preg_match('/[^0-9]*([0-9]*)[^0-9]*/', $this->number, $matches);
        $answer = $matches[1] ?? '';
//        dd($matches);
        if (is_numeric($answer)) {
            $this->number = str_replace($answer, ((int) $answer) + $amount, $this->number);
        }
    }

    public function getWinningAmount(string $placement): int
    {
        return match ($placement) {
            '1' => $this->first_prize,
            '2' => $this->second_prize,
            '3' => $this->third_prize,
            default => 0,
        };
    }

    public function getPrice(string $type): float
    {
        if ($type === Category::PRICE_EARLY_PRICE) {
            return $this->price;
        } else {
            return $this->late_price;
        }
    }

    public function isAdult(): bool
    {
        return is_null($this->maximum_age);
    }

    public function notAgeRestricted(Entrant $entrant): bool
    {
        if (is_null($this->minimum_age) && is_null($this->maximum_age)) {
            return true;
        }

        $age = $entrant->age;
        if (is_null($age)) {
            $age = 18;
        }

        if (!is_null($this->maximum_age) && $age > $this->maximum_age) {
            return false;
        }
        if (!is_null($this->minimum_age) && $age < $this->minimum_age) {
            return false;
        }

        return true;
    }

    public function isLatePriceCorrect(): bool
    {
        if ((int) $this->maximum_age > 0) {
            return $this->late_price === 0;
        }
        return $this->late_price > 0 && $this->late_price >= $this->price;
    }

    public function isPriceCorrect(): bool
    {
        if ((int) $this->maximum_age > 0) {
            return $this->price === 0;
        }
        return $this->price > 0;
    }
}
