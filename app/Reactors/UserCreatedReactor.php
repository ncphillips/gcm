<?php

namespace App\Reactors;

use App\Aggregates\TeamAggregate;
use App\StorableEvents\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class UserCreatedReactor extends Reactor implements ShouldQueue
{
    public function onUserCreated(UserCreated $event): void
    {
        $userUuid = $event->aggregateRootUuid();

        $uuid = (string)Str::uuid();

        TeamAggregate::retrieve($uuid)
            ->createPersonalTeamForUser(
                userUuid: $userUuid,
                userName: $event->name
            )
            ->persist();
    }
}
