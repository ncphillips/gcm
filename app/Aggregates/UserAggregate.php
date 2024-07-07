<?php

namespace App\Aggregates;

use App\StorableEvents\UserCreated;
use App\StorableEvents\UserPasswordChanged;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class UserAggregate extends AggregateRoot
{
    public string $name;
    public string $email;

    public function create($name, $email, $passwordHash): self
    {
        $this->recordThat(new UserCreated(email: $email, name: $name, passwordHash: $passwordHash));

        return $this;
    }

    public function changePassword(string $passwordHash): self
    {
        $this->recordThat(new UserPasswordChanged(passwordHash: $passwordHash, changedByUserUuid: $this->uuid()));

        return $this;
    }

    protected function applyUserCreated(UserCreated $event): void
    {
        $this->name = $event->name;
        $this->email = $event->email;
    }
}
