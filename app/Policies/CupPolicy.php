<?php

namespace App\Policies;

use App\Cup;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CupPolicy
{

    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(?User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Cup $cup
     * @return mixed
     */
    public function view(User $user, Cup $cup)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Cup $cup
     * @return mixed
     */
    public function update(User $user, Cup $cup)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Cup $cup
     * @return mixed
     */
    public function delete(User $user, Cup $cup)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Cup $cup
     * @return mixed
     */
    public function restore(User $user, Cup $cup)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Cup $cup
     * @return mixed
     */
    public function forceDelete(User $user, Cup $cup)
    {
        return $user->isAdmin();
    }
}
