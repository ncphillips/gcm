<?php

namespace App\Aggregates;

use App\StorableEvents\UserCreated;
use App\StorableEvents\UserEmailChanged;
use App\StorableEvents\UserNameChanged;
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

    public function changePassword(string $passwordHash, string|null $changedByUserUuid = null): self
    {
        $changedByUserUuid = $changedByUserUuid ?? $this->uuid();

        $this->recordThat(new UserPasswordChanged(passwordHash: $passwordHash, changedByUserUuid: $changedByUserUuid));

        return $this;
    }

    public function setName(string $name, string|null $changedByUserUuid = null): self
    {
        if ($this->name === $name) {
            return $this;
        }

        $changedByUserUuid = $changedByUserUuid ?? $this->uuid();

        $this->recordThat(new UserNameChanged(name: $name, changedByUserUuid: $changedByUserUuid));

        return $this;
    }

    public function setEmail(string $email, string|null $changedByUserUuid = null): self
    {
        if ($this->email === $email) {
            return $this;
        }

        $changedByUserUuid = $changedByUserUuid ?? $this->uuid();

        $this->recordThat(new UserEmailChanged(email: $email, changedByUserUuid: $changedByUserUuid));

        return $this;
    }

    protected function applyUserCreated(UserCreated $event): void
    {
        $this->name = $event->name;
        $this->email = $event->email;
    }

    protected function applyUserNameChanged(UserNameChanged $event): void
    {
        $this->name = $event->name;
    }

    protected function applyUserEmailChanged(UserEmailChanged $event): void
    {
        $this->email = $event->email;
    }
}
