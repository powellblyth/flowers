<?php

namespace App\Observers;

class UserObserver
{
    public function updating(User $user){
        event(new OrderShipped($order));

    }
}
