<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Card;
use Illuminate\Auth\Access\HandlesAuthorization;

class CardPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Card  $model
     * @return mixed
     */
    public function view(User $user)
    {
        return  $user->can('view-card');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create-card');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Card  $model
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->can('update-card');
    }
    

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Card  $model
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->can('delete-card');
    }

}
