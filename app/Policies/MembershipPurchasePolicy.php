<?php

namespace App\Policies;

use App\MembershipPurchase;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembershipPurchasePolicy
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
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param MembershipPurchase $purchase
     * @return mixed
     */
    public function view(User $user, MembershipPurchase $purchase)
    {
        return $user->isAdmin() || $purchase->user->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return config('app.state') !== 'locked';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param MembershipPurchase $purchase
     * @return mixed
     */
    public function update(User $user, MembershipPurchase $purchase)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param MembershipPurchase $purchase
     * @return mixed
     */
    public function delete(User $user, MembershipPurchase $purchase)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param MembershipPurchase $purchase
     * @return mixed
     */
    public function restore(User $user, MembershipPurchase $purchase)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param MembershipPurchase $purchase
     * @return mixed
     */
    public function forceDelete(User $user, MembershipPurchase $purchase)
    {
        return $user->isAdmin();
    }

    /**
     * Allows a user to see other people's detailed info
     */
    public function seeDetailedInfo(User $user, MembershipPurchase $purchase)
    {
        return $user->isAdmin() || $purchase->user instanceof User && ($user->id === $purchase->user->id);
    }

}
