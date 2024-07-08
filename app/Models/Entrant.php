<?php

namespace App\Models;

use App\Events\EntrantSaving;
use Database\Factories\EntrantFactory;
use DB;
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
        'can_retain_data',
    ];


//    use Billable;

    protected $dispatchesEvents = [
        'saving' => EntrantSaving::class
    ];

    protected function printableName(): Attribute
    {
        return new Attribute(
            get: fn($value) => trim(substr($this->first_name, 0, 1) . ' ' . $this->family_name)
        );
    }

    protected function ageDescription(): Attribute
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

    protected function entrantNumber(): Attribute
    {
        return new Attribute(
            get: fn($value) => 'E-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT)
        );
    }

    protected function numberedName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->entrant_number . ' ' . $this->full_name
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::title(
                trim($this->first_name . ' ' . $this->family_name)
            )
        );
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

    /**
     * Merge another entrant's data into this one
     * @param Entrant $mergeIntoEntrant
     * @return void
     */
    public function mergeInto(Entrant $mergeIntoEntrant)
    {
        try {
            DB::beginTransaction();
            $this->entries()->each(
                function (Entry $entry) use ($mergeIntoEntrant) {
                    $entry->entrant()->associate($mergeIntoEntrant);
                    $entry->save();
                }
            );

            $this->membershipPurchases()->each(
                function (MembershipPurchase $membershipPurchase) use ($mergeIntoEntrant) {
                    $membershipPurchase->entrant()->associate($mergeIntoEntrant);
                    $membershipPurchase->user()->associate($mergeIntoEntrant->user);
                    $membershipPurchase->save();
                }
            );

            $this->payments()->each(
                function (Payment $payment) use ($mergeIntoEntrant) {
                    $payment->entrant()->associate($mergeIntoEntrant);
                    $payment->user()->associate($mergeIntoEntrant->user);
                    $payment->save();
                }
            );

            DB::table('cup_winner_archives')
                ->where('cup_winner_entrant_id', $this->id)
                ->update(['cup_winner_entrant_id' => $mergeIntoEntrant->id]);

            DB::table('cup_winner_archive_winners')
                ->where('entrant_id', $this->id)
                ->update(['entrant_id' => $mergeIntoEntrant->id]);

            // Don't really use this field but... referential integrity and all that
            DB::table('cup_direct_winners')
                ->where('entrant_id', $this->id)
                ->update(['entrant_id' => $mergeIntoEntrant->id]);

            DB::table('entrant_team')
                ->where('entrant_id', $this->id)
                ->update(['entrant_id' => $mergeIntoEntrant->id]);

            $metaData = [
                'merged_from' => [
                    'first_name' => $this->first_name,
                    'family_name' => $this->family_name,
                    'membernumber' => $this->membernumber,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                    'age' => $this->age,
                    'approx_birth_year' => $this->approx_birth_year,
                    'can_retain_data' => $this->can_retain_data,
                    'retain_data_opt_in' => $this->retain_data_opt_in,
                    'retain_data_opt_out' => $this->retain_data_opt_out,
                ]
            ];
            $mergeEntrantLog = new MergeEntrantLog();
            $mergeEntrantLog->mergeFromEntrant()->associate($this);
            $mergeEntrantLog->mergeToEntrant()->associate($mergeIntoEntrant);
            $mergeEntrantLog->mergeFromUser()->associate($this->user);
            $mergeEntrantLog->mergeToUser()->associate($mergeIntoEntrant->user);
            $mergeEntrantLog->metadata = $metaData;
            $mergeEntrantLog->merge_type = 'MergeEntrantIntoEntrant';
            $mergeEntrantLog->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function moveToUser(User $user): void
    {
        try {
            DB::beginTransaction();

//            dump($this->user->id);
//            dump($user->id);
            $this->user()->associate($user);
//            dump($this->user->id);
            $this->save();
//            dd($user->id);
            $this->payments()
                ->where('user_id', $user->id)
                ->each(function (Payment $payment) {
                    $payment->user()->associate($this);
                });
            $this->membershipPurchases()
                ->where('user_id', $user->id)
                ->each(function (MembershipPurchase $membershipPurchase) {
                    $membershipPurchase->user()->associate($this);
                });

            $mergeEntrantLog = new MergeEntrantLog();
            $mergeEntrantLog->mergeFromEntrant()->associate($this);
            $mergeEntrantLog->mergeToEntrant()->associate($this);
            $mergeEntrantLog->mergeFromUser()->associate($this->user);
            $mergeEntrantLog->mergeToUser()->associate($user);
            $mergeEntrantLog->metadata = [];
            $mergeEntrantLog->merge_type = 'MoveEntrantToUser';
            $mergeEntrantLog->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
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
