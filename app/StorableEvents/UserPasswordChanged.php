<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserPasswordChanged extends ShouldBeStored
{
    public function __construct(
        public string $passwordHash,
        public string $changedByUserUuid,
    )
    {
    }
}
