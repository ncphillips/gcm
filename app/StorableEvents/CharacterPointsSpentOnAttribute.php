<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CharacterPointsSpentOnAttribute extends ShouldBeStored
{
    public function __construct(
        public string $attr_id,
        public int $points,
    )
    {
    }
}
