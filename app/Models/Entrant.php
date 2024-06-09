<?php

namespace App\Models;

use App\Events\EntrantSaving;
use Database\Factories\EntrantFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

//use Laravel\Cashier\Billable;

/**
 * App\Models\Entrant
 *
 * @property int $id
 * @property string $first_name
 * @property string $family_name
 * @property string|null $membernumber
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $age
 * @property bool|null $can_retain_data
 * @property Carbon|null $retain_data_opt_in
 * @property int|null $user_id
 * @property bool $is_anonymised
 * @property Carbon|null $retain_data_opt_out
 * @property-read Collection|Entry[] $entries
 * @property-read int|null $entries_count
 * @property-read string $age_description
 * @property-read string $full_name
 * @property-read Collection|MembershipPurchase[] $individualMemberships
 * @property-read int|null $individual_memberships_count
 * @property-read Collection|MembershipPurchase[] $membershipPurchases
 * @property-read int|null $membership_purchases_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read Collection|Team[] $teams
 * @property-read int|null $teams_count
 * @property-read User|null $user
 * @method static EntrantFactory factory(...$parameters)
 * @method static Builder|Entrant newModelQuery()
 * @method static Builder|Entrant newQuery()
 * @method static Builder|Entrant query()
 * @method static Builder|Entrant whereAge($value)
 * @method static Builder|Entrant whereCanRetainData($value)
 * @method static Builder|Entrant whereCreatedAt($value)
 * @method static Builder|Entrant whereFamilyName($value)
 * @method static Builder|Entrant whereFirstName($value)
 * @method static Builder|Entrant whereId($value)
 * @method static Builder|Entrant whereIsAnonymised($value)
 * @method static Builder|Entrant whereMembernumber($value)
 * @method static Builder|Entrant whereRetainDataOptIn($value)
 * @method static Builder|Entrant whereRetainDataOptOut($value)
 * @method static Builder|Entrant whereUpdatedAt($value)
 * @method static Builder|Entrant whereUserId($value)
 * @property int|null $approx_birth_year
 * @method static Builder|Entrant whereApproxBirthYear($value)
 * @mixin \Eloquent
 */
class Entrant extends Model
{
    use Notifiable;
    use HasFactory;

    protected $casts = [
        'can_retain_data' => 'bool',
        'retain_data_opt_in' => 'datetime',
        'retain_data_opt_out' => 'datetime',
        'is_anonymised' => 'bool',
        'age' => 'int',
    ];

    public $fillable = [
        'age',
        'first_name',
        'family_name',
        'membernumber',
        'age',
        'can_retain_data',
    ];


//    use Billable;

    protected $dispatchesEvents = [
        'saving' => EntrantSaving::class
    ];

    public function printableName(): Attribute
    {
        return new Attribute(
            get: fn($value) => trim(substr($this->first_name, 0, 1) . ' ' . $this->family_name)
        );
    }

    public function entrantNumber(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->getEntrantNumber()
        );
    }

    public function numberedName(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->getEntrantNumber() .' ' . $this->full_name
        );
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn($value) => Str::title(trim($this->first_name . ' ' . $this->family_name))
        );
    }

    /**
     * Simple way to get an entrant number
     */
    public function getEntrantNumber(): string
    {
        return 'E-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Simple way to get an entrant number
     */
    public function getAddressDetails($joiningChars = ', '): string
    {
        $addressItems = [];
        if ($this->user) {
            if (!empty($this->user->address)) {
                $addressItems[] = $this->user->address;
            }
            if (!empty($this->user->email)) {
                $addressItems[] = $this->user->email;
            }
            if (!empty($this->user->telephone)) {
                $addressItems[] = $this->user->telephone;
            }
        }
        return implode($joiningChars, $addressItems);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canJoin(Team $team): bool
    {
        return ($this->age <= $team->max_age && $this->age >= $team->min_age);
    }

    public function isChild(): bool
    {
        return $this->age && $this->age < 18;
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->withTimestamps()
            ->withPivot('show_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function membershipPurchases(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class);
    }

    public function getValidTeamOptions(): array
    {
        $entrant = $this;

        $teamQuery = $this->age ? Team::where('max_age', '>=', (int) $this->age) : Team::query();
        return $teamQuery
            ->orderBy('min_age')
            ->orderBy('max_age')
            ->orderBy('name')
            ->get()
            ->reject(function (Team $team) use ($entrant) {
                return !$entrant->canJoin($team);
            })
            ->pluck('name', 'id')->toArray();
    }

    public function anonymise(): Entrant
    {
        $this->is_anonymised = true;
        $this->first_name = 'Anonymised';
        $this->family_name = 'Anonymised';
        $this->membernumber = null;
        $this->age = null;

        // some of these are legacy fields
        $this->retain_data_opt_in = null;
        $this->retain_data_opt_out = null;

        $this->created_at = null;

        return $this;
    }
//    public function
}
