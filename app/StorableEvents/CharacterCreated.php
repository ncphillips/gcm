<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CharacterCreated extends ShouldBeStored
{
    public function __construct(
        public string $playerUuid
    )
    {
    }
}
