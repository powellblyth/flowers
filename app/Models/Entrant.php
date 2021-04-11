<?php

namespace App\Models;

use App\Events\EntrantSaving;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

//use Laravel\Cashier\Billable;

/**
 * Class Entrant
 * @package App
 * @property User $user
 * @property string firstname
 * @property string familyname
 * @property bool can_retain_data
 * @property bool is_anonymised
 * @property int age
 * @property Collection individualMemberships
 * @property Carbon retain_data_opt_out
 * @property Carbon retain_data_opt_in
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property int id
 * @property string membernumber
 * @property int user_id
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

//    use Billable;

    protected $dispatchesEvents = [
        'saving' => EntrantSaving::class
    ];

    public function getFullNameAttribute(): string
    {
        return $this->getName();
    }

    public function getName(bool $printable = null): string
    {
        if ($printable) {
            return $this->getPrintableName();
        } else {
            return Str::title(trim($this->firstname . ' ' . $this->familyname));
        }
    }

    /**
     * Simple way to get an entrant number
     */
    public function getEntrantNumber(): string
    {
        return 'E-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getPrintableName(): string
    {
        return trim(substr($this->firstname, 0, 1) . ' ' . $this->familyname);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canJoin(Team $team): bool
    {
        return ($this->age <= $team->max_age && $this->age >= $team->min_age);
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
            ->get()->reject(function (Team $team) use ($entrant) {
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
