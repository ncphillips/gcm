<?php

namespace App\Aggregates;

use App\StorableEvents\UserCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class UserAggregate extends AggregateRoot
{
    public string $name;
    public string $email;

    public function create($name, $email): self
    {
        $this->recordThat(new UserCreated(email: $email, name: $name));

        return $this;
    }

    protected function applyUserCreated(UserCreated $event): void
    {
        $this->name = $event->name;
        $this->email = $event->email;
    }
}
