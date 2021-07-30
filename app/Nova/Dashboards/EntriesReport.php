<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\MembershipPriceByMembershipType;
use App\Nova\Metrics\MembershipsByMembershipType;
use Laravel\Nova\Dashboard;

class EntriesReport extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            MembershipsByMembershipType::make(),
            MembershipPriceByMembershipType::make(),
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'entries-report';
    }
}
