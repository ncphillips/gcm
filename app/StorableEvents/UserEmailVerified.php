<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserEmailVerified extends ShouldBeStored
{
    public function __construct()
    {
    }
}
