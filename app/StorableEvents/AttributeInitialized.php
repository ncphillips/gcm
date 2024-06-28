<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AttributeInitialized extends ShouldBeStored
{
    public function __construct(
        public string $characterUuid,
        public string $attrId,
        public int    $costPerPoint,
    )
    {
    }
}
