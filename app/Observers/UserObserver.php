<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function updating(User $user)
    {
        event(new OrderShipped($user));

    }
}
