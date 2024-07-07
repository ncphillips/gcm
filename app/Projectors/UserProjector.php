<?php

namespace App\Projectors;

use App\Models\Team;
use App\Models\User;
use App\StorableEvents\UserCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
}
