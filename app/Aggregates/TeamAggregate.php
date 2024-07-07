<?php

namespace App\Aggregates;

use App\StorableEvents\TeamCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class TeamAggregate extends AggregateRoot
{

    public string $name;
    public string $userUuid;
    public bool $personalTeam;

    public function createPersonalTeamForUser(string $userUuid, string $userName): self
    {
        $name = explode(' ', $userName, 2)[0] . "'s Team";

        $this->recordThat(new TeamCreated(userUuid: $userUuid, name: $name, personalTeam: true));

        return $this;
    }

    public function create(string $userUuid, string $name): self
    {
        $this->recordThat(new TeamCreated(userUuid: $userUuid, name: $name, personalTeam: false));

        return $this;
    }

    protected function applyTeamCreated(TeamCreated $event): void
    {
        $this->userUuid = $event->userUuid;
        $this->name = $event->name;
        $this->personalTeam = $event->personalTeam;
    }
}
