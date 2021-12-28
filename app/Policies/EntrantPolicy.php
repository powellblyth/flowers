<?php

namespace App\Policies;

use App\Models\Entrant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntrantPolicy
{

    use HandlesAuthorization;

    public function before($user, $ability)
    {
//        if ($user->isAdmin()) {
//            return true;
//        }
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
     * @return mixed
     */
    public function view(User $user, Entrant $entrant)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return config('app.state') !== 'locked';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, Entrant $entrant)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, Entrant $entrant)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore(User $user, Entrant $entrant)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Entrant $entrant)
    {
        return $user->isAdmin();
    }

    public function createEntries(User $user, Entrant $entrant)
    {
        return $user->isAdmin() || $entrant->user->is($user);
    }

    /**
     * Allows a user to see other people's detailed info
     */
    public function seeDetailedInfo(User $user, Entrant $entrant)
    {
        return $user->isAdmin() || $entrant->user instanceof User && ($user->id === $entrant->user->id);
    }

}
