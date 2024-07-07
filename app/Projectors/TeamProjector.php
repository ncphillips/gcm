<?php

namespace App\Projectors;

use App\Models\Team;
use App\Models\User;
use App\StorableEvents\TeamCreated;
use App\StorableEvents\TeamDeleted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TeamProjector extends Projector
{
    public function onTeamCreated(TeamCreated $event): void
    {
        $user = User::where('uuid', $event->userUuid)->first();

        $user->ownedTeams()->save(Team::forceCreate([
            'uuid' => $event->aggregateRootUuid(),
            'user_id' => $user->id,
            'name' => $event->name,
            'personal_team' => $event->personalTeam,
        ]));
    }

    public function onTeamDeleted(TeamDeleted $event): void
    {
        $team = Team::where('uuid', $event->aggregateRootUuid())->first();

        $team->purge();
    }
}
