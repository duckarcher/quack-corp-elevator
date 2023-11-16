<?php

namespace App\Policies;

use App\Models\Elevator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ElevatorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {

    }

    public function view(User $user, Elevator $elevator)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, Elevator $elevator)
    {
    }

    public function delete(User $user, Elevator $elevator)
    {
    }

    public function restore(User $user, Elevator $elevator)
    {
    }

    public function forceDelete(User $user, Elevator $elevator)
    {
    }
}
