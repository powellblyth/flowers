<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboard;

class MembershipsReport extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            //
        ];
    }

    /**
     * Get the URI key for the dashboard.
     */
    public static function uriKey(): string
    {
        return 'memberships-report';
    }
}
