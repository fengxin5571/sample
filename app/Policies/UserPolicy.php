<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $loginedUser,User $user){
        return $loginedUser->id===$user->id;
    }
    public function show(User $loginedUser,User $user){
        return $loginedUser->id===$user->id;
    }
}
