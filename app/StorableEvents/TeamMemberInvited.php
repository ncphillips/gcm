<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TeamMemberInvited extends ShouldBeStored
{
    public function __construct(
        public string $email,
        public string $role,
        public string $invitedByUserUuid,
    )
    {
    }
}
