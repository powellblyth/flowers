<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
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
        die('I am here');
        dd($user);
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Team $team
     * @return mixed
     */
    public function view(User $user, Team $team)
    {
        die('here ' . __LINE__);
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
        die('here ' . __LINE__);
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Team $team
     * @return mixed
     */
    public function update(User $user, Team $team)
    {
        die('here ' . __LINE__);
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Team $team
     * @return mixed
     */
    public function delete(User $user, Team $team)
    {
        die('here ' . __LINE__);
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Team $team
     * @return mixed
     */
    public function restore(User $user, Team $team)
    {
        die('here ' . __LINE__);
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Team $team
     * @return mixed
     */
    public function forceDelete(User $user, Team $team)
    {
        die('here ' . __LINE__);
        return $user->isAdmin();
    }
}
