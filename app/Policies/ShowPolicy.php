<?php

namespace App\Policies;

use App\Models\Show;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShowPolicy
{

    use HandlesAuthorization;


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
     * @param Show $show
     * @return mixed
     */
    public function view(User $user, Show $show)
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
     * @param Show $show
     * @return mixed
     */
    public function update(User $user, Show $show)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Show $show
     * @return mixed
     */
    public function delete(User $user, Show $show)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Show $show
     * @return mixed
     */
    public function restore(User $user, Show $show)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Show $show
     * @return mixed
     */
    public function forceDelete(User $user, Show $show)
    {
        return $user->isAdmin();
    }

    public function storeResults(User $user, Show $show)
    {
        return $user->isAdmin() && $show->isCurrent();
    }
}
