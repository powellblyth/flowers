<?php
return [
    'entrant' =>
        [
            'prevent_if_column_different' => [
                'user_id',
            ],
            'just_change_id' =>
                [
                    \App\Models\Entry::class,
                    \App\Nova\MembershipPurchase::class,
                    \App\Models\CupDirectWinner::class,
                    \App\Models\Payment::class,
                ],
            'keep_newest' =>
                [
                    'entrant_team',
                ],
        ],
    'user' =>
        [
            'just_change_id' =>
                [
                    'entrants',
                    'membershipPurchases',
                    'paymentCards',
                    'payments',
                    'subscriptions',
                    'actionEvents',
                ],
            'keep_newest' =>
                [

                ],
        ],
];
