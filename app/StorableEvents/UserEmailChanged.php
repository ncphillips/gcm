<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserEmailChanged extends ShouldBeStored
{
    public function __construct(
        public string $email,
        public string $changedByUserUuid
    )
    {
    }
}
