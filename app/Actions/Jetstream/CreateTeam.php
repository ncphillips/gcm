<?php

namespace App\Actions\Jetstream;

use App\Aggregates\TeamAggregate;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param array<string, string> $input
     */
    public function create(User $user, array $input): Team
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $teamUuid = (string)Str::uuid();

        TeamAggregate::retrieve($teamUuid)
            ->create(userUuid: $user->uuid, name: $input['name'])
            ->persist();

        $team = Team::where('uuid', $teamUuid)->first();

        $user->switchTeam($team);

        return $team;
    }
}
