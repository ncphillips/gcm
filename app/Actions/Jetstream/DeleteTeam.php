<?php

namespace App\Actions\Jetstream;

use App\Aggregates\TeamAggregate;
use App\Models\Team;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        TeamAggregate::retrieve($team->uuid)
            ->delete(auth()->user()->uuid)
            ->persist();
    }
}
