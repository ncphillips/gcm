<?php

namespace App\Aggregates;

use App\StorableEvents\TeamCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class TeamAggregate extends AggregateRoot
{
    public string $name;
    public bool $personalTeam;

    public function create(string $name, bool $personalTeam): self
    {
        $this->recordThat(new TeamCreated(name: $name, personalTeam: $personalTeam));

        return $this;
    }

    protected function applyTeamCreated(TeamCreated $event): void
    {
        $this->name = $event->name;
        $this->personalTeam = $event->personalTeam;
    }
}
