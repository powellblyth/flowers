<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    use HandlesAuthorization;

    public function before($user, $ability)
    {

        if (
            !in_array($ability, ['delete', 'forceDelete'])
            && $user->isAdmin()
        ) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Allows a user to see other people's detailed info
     * @return bool
     */
    public function seeDetailedInfo(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Allows a user to add entrants
     * @return bool
     */
    public function addEntrant(User $user, User $model)
    {
        return $user->id === $model->id;
    }


    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id = $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return ($user->isAdmin() && $user->id !== $model->id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return false;
    }

    public function logInToNova(User $user, User $model)
    {
        return $user->isAdmin();
    }
}
