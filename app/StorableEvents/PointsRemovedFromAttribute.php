<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PointsRemovedFromAttribute extends ShouldBeStored
{
    public function __construct(
        public int $points
    )
    {
    }
}
