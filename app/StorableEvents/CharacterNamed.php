<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CharacterNamed extends ShouldBeStored
{
    public function __construct(
        public string $name,
    )
    {
    }
}
