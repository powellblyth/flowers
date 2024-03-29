<?php

namespace App\Nova;

/**
 * @mixin \App\Models\CommitteeMember
 */
class CommitteeMember extends User
{
    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static array $sort = [
        'is_committee' => 'desc',
        'last_name' => 'asc',
        'first_name' => 'asc',
    ];

    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\CommitteeMember::class;


    public static function label(): string
    {
        return 'Committee Members';
    }


}
