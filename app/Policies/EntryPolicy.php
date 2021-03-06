<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Entry $entry
     * @return mixed
     */
    public function view(User $user, Entry $entry)
    {
        return $entry->entrant->user->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Entry $entry
     * @return mixed
     */
    public function update(User $user, Entry $entry)
    {
        return $entry->entrant->user->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Entry $entry
     * @return mixed
     */
    public function delete(User $user, Entry $entry)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Entry $entry
     * @return mixed
     */
    public function restore(User $user, Entry $entry)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Entry $entry
     * @return mixed
     */
    public function forceDelete(User $user, Entry $entry)
    {
        return false;
    }

    public function printCards(User $user){
        return false;
    }
    public function enterResults(User $user){
        return false;
    }
}
