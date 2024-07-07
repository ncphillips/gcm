<?php

namespace App\Projectors;

use App\Models\User;
use App\StorableEvents\UserCreated;
use App\StorableEvents\UserPasswordChanged;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserProjector extends Projector
{
    public function onUserCreated(UserCreated $event)
    {
        User::create([
            'uuid' => $event->aggregateRootUuid(),
            'name' => $event->name,
            'email' => $event->email,
            'password' => $event->passwordHash,
        ]);
    }

    public function onUserPasswordChanged(UserPasswordChanged $event): void
    {
        User::where('uuid', $event->aggregateRootUuid())
            ->update(['password' => $event->passwordHash]);
    }
}
