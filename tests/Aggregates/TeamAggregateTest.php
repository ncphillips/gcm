<?php

namespace Tests\Aggregates;

use App\Aggregates\TeamAggregate;
use App\Aggregates\UserAggregate;
use App\StorableEvents\TeamCreated;
use App\StorableEvents\UserCreated;
use Illuminate\Support\Str;

test('creating a team', function () {
    $uuid = (string) Str::uuid();
    $name = 'John Doe\'s Team';

    /** @var TeamAggregate $team */
    $team = TeamAggregate::fake($uuid)
        ->when(fn(TeamAggregate $team) => $team->create(name: $name, personalTeam: true))
        ->assertRecorded(new TeamCreated(name: $name, personalTeam: true))
        ->aggregateRoot();

    expect($team->name)->toBe($name)
        ->and($team->personalTeam)->toBe(true);
});
