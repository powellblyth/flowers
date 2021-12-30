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
use Illuminate\Support\Str;

//use Laravel\Cashier\Billable;

/**
 * App\Models\Entrant
 *
 * @property int $id
 * @property string $firstname
 * @property string $familyname
 * @property string|null $membernumber
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $age
 * @property bool|null $can_retain_data
 * @property \Illuminate\Support\Carbon|null $retain_data_opt_in
 * @property int|null $user_id
 * @property bool $is_anonymised
 * @property \Illuminate\Support\Carbon|null $retain_data_opt_out
 * @property-read Collection|Entry[] $entries
 * @property-read int|null $entries_count
 * @property-read string $age_description
 * @property-read string $full_name
 * @property-read Collection|\App\Models\MembershipPurchase[] $individualMemberships
 * @property-read int|null $individual_memberships_count
 * @property-read Collection|\App\Models\MembershipPurchase[] $membershipPurchases
 * @property-read int|null $membership_purchases_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read Collection|\App\Models\Team[] $teams
 * @property-read int|null $teams_count
 * @property-read \App\Models\User|null $user
 * @method static EntrantFactory factory(...$parameters)
 * @method static Builder|Entrant newModelQuery()
 * @method static Builder|Entrant newQuery()
 * @method static Builder|Entrant query()
 * @method static Builder|Entrant whereAge($value)
 * @method static Builder|Entrant whereCanRetainData($value)
 * @method static Builder|Entrant whereCreatedAt($value)
 * @method static Builder|Entrant whereFamilyname($value)
 * @method static Builder|Entrant whereFirstname($value)
 * @method static Builder|Entrant whereId($value)
 * @method static Builder|Entrant whereIsAnonymised($value)
 * @method static Builder|Entrant whereMembernumber($value)
 * @method static Builder|Entrant whereRetainDataOptIn($value)
 * @method static Builder|Entrant whereRetainDataOptOut($value)
 * @method static Builder|Entrant whereUpdatedAt($value)
 * @method static Builder|Entrant whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $approx_birth_year
 * @method static Builder|Entrant whereApproxBirthYear($value)
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
    ];


//    use Billable;

    protected $dispatchesEvents = [
        'saving' => EntrantSaving::class
    ];

    public function printableName(): Attribute
    {
        return new Attribute(
            get: fn($value) => trim(substr($this->firstname, 0, 1) . ' ' . $this->familyname)
        );
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn($value) => Str::title(trim($this->firstname . ' ' . $this->familyname))
        );
    }

    public function ageDescription(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                if (!$this->age) {
                    return '';
                }
                if ($this->age >= 18) {
                    return '';
                }
                return __(':age years', ['age' => $this->age]);
            }
        );
    }

    /**
     * Simple way to get an entrant number
     */
    public function getEntrantNumber(): string
    {
        return 'E-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
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

    public function individualMemberships(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class, 'entrant_id');
    }

    public function getValidTeamOptions(): array
    {
        $entrant = $this;

        if (!$this->age) {
            $teamQuery = Team::query();
        } else {
            $teamQuery = Team::where('max_age', '>=', (int) $this->age);
        }
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

    public function familyMembership(): ?MembershipPurchase
    {
        if ($this->user instanceof User) {
            return $this->user->familyMemberships()->first();
        } else {
            return null;
        }
    }

    public function getCurrentMembership(): ?MembershipPurchase
    {
        $membership = $this->individualMemberships()
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->where('type', 'single')
            ->first();

        if (!$membership instanceof MembershipPurchase || $membership->isNotExpired()) {
            $membership = $this->familyMembership();
        }
        if ($membership instanceof MembershipPurchase && $membership->isNotExpired()) {
            return $membership;
        } else {
            return null;
        }
    }

    public function isAMember(): bool
    {
        return $this->individualMemberships->count() > 0 || $this->familyMembership()->count() > 0;
    }

    public function getMemberNumber()
    {
        $membership = $this->getCurrentMembership();
        if ($membership instanceof MembershipPurchase) {
            return $membership->getNumber();
        } else {
            return null;
        }
    }

    public function anonymise(): Entrant
    {
        $this->is_anonymised = true;
        $this->firstname = 'Anonymised';
        $this->familyname = 'Anonymised';
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
