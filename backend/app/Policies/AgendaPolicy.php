<?php

namespace App\Policies;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgendaPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Agenda $agenda)
    {
        return $user->id === $agenda->user_id ||
            $agenda->sharedUsers->contains($user->id);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Agenda $agenda)
    {
        return $user->id === $agenda->user_id;
    }

    public function delete(User $user, Agenda $agenda)
    {
        return $user->id === $agenda->user_id;
    }

    public function share(User $user, Agenda $agenda)
    {
        return $user->id === $agenda->user_id;
    }
}