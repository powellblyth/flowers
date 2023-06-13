<?php

namespace App\Nova;

use App\Nova\Actions\CreateFamilyMembership;
use App\Nova\Actions\CreateSingleMembership;
use App\Nova\Actions\PrintAllCardsRedirector;
use App\Nova\Actions\RecordPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

/**
 * @mixin \App\Models\User
 */
class User extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\User::class;

    /**
     * Default ordering for index query.
     */
    public static $sort = [
        'last_name' => 'asc',
        'first_name' => 'asc',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_name';
    public static $group = 'members';

    public static function label(): string
    {
        return 'Family Managers';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'email',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'address_town',
        'postcode',
        'telephone',
    ];

    /**
     * The columns that should be concatenated and searched.
     * Part of akki-io/laravel-nova-search
     * @var array
     */
    public static $searchConcatenation = [
        ['first_name', 'last_name'],
        ['last_name', 'first_name'],
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Gravatar::make()->maxWidth(50),
            Text::make(__('Name'), fn(\App\Models\User $user) => $user->fullName),
            Text::make(
                __('Membership Number'),
                fn(\App\Models\User $user) => $user->getMemberNumber()
            ),

            Text::make('Fees for current show', function () {
                $fees = 0;
                $freeEntries = 0;
                $entries = 0;
                foreach ($this->entrants as $entrant) {
                    foreach ($entrant->entries()->where('show_id', 6)->get() as $entry) {
                        $entryPrice = (int) $entry->getActualPrice();
                        $fees += $entryPrice;
                        $entries++;
                        if (0 === $entryPrice) {
                            $freeEntries++;
                        }
                    }
                }
//                return '£' . ($fees/100);
                $payments = 0;
                foreach ($this->payments()->where('created_at', '>', '2022-01-01 00:00:00')->get() as $payment) {
                    $payments += (int) $payment->amount;
                }

                $memberships = $this->membershipPurchases()
                    ->where('created_at', '>', '2022-06-01 00:00:00')
                    ->get();
                $numMembership = $memberships->count();
                $amountMemberships = $memberships->sum('amount');

                $owed = (($fees + $amountMemberships) - $payments);

                return '' . $entries . ' ' . Str::plural('Entry', $entries) .
                       ' (' . $freeEntries . ' ' . Str::plural('free entries') . ')' .
                       ' - £' . ($fees / 100) . '<br />' .
                       $numMembership . ' ' . Str::plural('Membership', $numMembership) .
                       ' - £' . ($amountMemberships / 100) . '<br />' .
                       '------------<br />' .
                       '= £' . (($fees + $amountMemberships) / 100) . ' fees <br />' .
                       '------------<br />' .
                       'less £' . ($payments / 100) . ' of payments <br />' .
                       '<b>----------------</b><br />' .

                       '=  <big><b>£' . ($owed / 100) . ' owed</b></big><br />' .
                       '<b>----------------</b><br />';
            })->asHtml()->onlyOnDetail(),

            Select::make('Status')
                ->sortable()
                ->rules('required', 'max:255')
                ->options(\App\Models\User::getAllStatuses()),

            Select::make('Type')
                ->sortable()
                ->options(\App\Models\User::getAllTypes()),

            Text::make('First Name', 'first_name')
                ->sortable()
                ->rules('required', 'max:255')
                ->onlyOnForms(),

            Text::make('Family Name', 'last_name')
                ->sortable()
                ->rules('required', 'max:255')
                ->onlyOnForms(),

            Text::make('Email')
                ->sortable()
                ->required(false)
                ->rules('sometimes:email:max:254')
                ->creationRules('sometimes:unique:users,email')
                ->updateRules('sometimes:unique:users,email,{{resourceId}}'),

            //            // why do I even have this?
            //            Password::make('Password')
            //                ->onlyOnForms()
            //                ->creationRules('nullable', 'string', 'min:8')
            //                ->updateRules('nullable', 'string', 'min:8')
            //                ->hideWhenCreating()
            //                ->hideWhenEditing()
            //            ,
            Text::make('Address 1')->onlyOnForms(),
            Text::make('Address 2')->onlyOnForms(),
            Text::make('Town', 'address_town')->onlyOnForms(),
            Text::make('Postcode')->onlyOnForms(),
            Text::make('Address', function (\App\Models\User $user) {
                return $user->address;
            })->asHtml()->onlyOnDetail(),
            Text::make('Telephone')->hideFromIndex(),
            Boolean::make('Can Retain Data')->hideFromIndex(),
            DateTime::make('Retain Data Opt in')->onlyOnDetail()->readonly(),
            DateTime::make('Retain Data Opt out')->onlyOnDetail()->readonly(),
            Boolean::make('Can Email')->hideFromIndex(),
            DateTime::make('Email Opt in')->onlyOnDetail()->readonly(),
            DateTime::make('Email Opt Out')->onlyOnDetail()->readonly(),
            Boolean::make('Can Phone')->hideFromIndex(),
            DateTime::make('Phone Opt in')->onlyOnDetail()->readonly(),
            DateTime::make('Phone Opt out')->onlyOnDetail()->readonly(),
            Boolean::make('Can SMS', 'can_sms')->hideFromIndex(),
            Boolean::make('Is Committee Member', 'is_committee')->hideFromIndex()->default(false),
            DateTime::make('SMS Opt-in', 'sms_opt_in')->onlyOnDetail()->readonly(),
            DateTime::make('SMS Opt-out', 'sms_opt_out')->onlyOnDetail()->readonly(),

            DateTime::make('Created At', 'created_at')->onlyOnDetail()->readonly(),
            DateTime::make('Updated At', 'updated_at')->onlyOnDetail()->readonly(),

            HasMany::make('Entrants'),
            HasMany::make('Memberships', 'membershipPurchases', MembershipPurchase::class),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        return [
            RecordPayment::make(),
            PrintAllCardsRedirector::make()->showOnIndex(),
            CreateFamilyMembership::make()->showOnIndex()->showOnTableRow(),
            CreateSingleMembership::make()->showOnIndex()->showOnTableRow(),
        ];
    }
}
