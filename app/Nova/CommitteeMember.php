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
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

/**
 * @mixin \App\Models\CommitteeMember
 */
class CommitteeMember extends \App\Nova\User
{
    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'is_committee' => 'desc',
        'last_name' => 'asc',
        'first_name' => 'asc',
    ];

    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\User::class;


    public static function label(): string
    {
        return 'Committee Members';
    }


}
