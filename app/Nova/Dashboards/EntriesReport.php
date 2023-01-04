<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\MembershipValueByMembershipType;
use App\Nova\Metrics\ActiveMembershipsByMembershipType;
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
            ActiveMembershipsByMembershipType::make(),
            MembershipValueByMembershipType::make(),
        ];
    }

    /**
     * Get the URI key for the dashboard.
     */
    public static function uriKey(): string
    {
        return 'entries-report';
    }
}
