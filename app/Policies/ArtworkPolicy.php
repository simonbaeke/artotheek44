<?php

namespace App\Policies;

use App\Models\Artwork;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ArtworkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Artwork  $artwork
     * @return mixed
     */
    public function view(User $user, Artwork $artwork)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Artwork  $artwork
     * @return mixed
     */
    public function update(User $user, Artwork $artwork)
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('you do not have permission to update an artwork');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Artwork  $artwork
     * @return mixed
     */
    public function delete(User $user, Artwork $artwork)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Artwork  $artwork
     * @return mixed
     */
    public function restore(User $user, Artwork $artwork)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Artwork  $artwork
     * @return mixed
     */
    public function forceDelete(User $user, Artwork $artwork)
    {
        //
    }
}
