<?php

namespace App\Policies;

use App\Models\User;
use App\Models\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {

        return true;
    }

    public function update(User $user)
    {

        return true;
    }

    public function delete(User $user)
    {

        return true;
    }
}
