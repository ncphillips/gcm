<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserNameChanged extends ShouldBeStored
{
    public function __construct(
        public string $name,
        public string $changedByUserUuid
    )
    {
    }
}
