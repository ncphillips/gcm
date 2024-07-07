<?php

namespace Tests\Aggregates;

use App\Aggregates\TeamAggregate;
use App\Aggregates\UserAggregate;
use App\StorableEvents\TeamCreated;
use App\StorableEvents\UserCreated;
use Illuminate\Support\Str;

test('creating a personal team', function () {
    $uuid = (string)Str::uuid();
    $userUuid = (string)Str::uuid();
    $userName = 'Test User';

    $teamName = 'Test\'s Team';

    /** @var TeamAggregate $team */
    $team = TeamAggregate::fake($uuid)
        ->when(fn(TeamAggregate $team) => $team->createPersonalTeamForUser(userUuid: $userUuid, userName: $userName))
        ->assertRecorded(new TeamCreated(userUuid: $userUuid, name: $teamName, personalTeam: true))
        ->aggregateRoot();

    expect($team->name)->toBe($teamName)
        ->and($team->userUuid)->toBe($userUuid)
        ->and($team->personalTeam)->toBe(true);
});

test('creating a team', function () {
    $uuid = (string)Str::uuid();
    $userUuid = (string)Str::uuid();

    $teamName = 'A New Team';

    /** @var TeamAggregate $team */
    $team = TeamAggregate::fake($uuid)
        ->when(fn(TeamAggregate $team) => $team->create(userUuid: $userUuid, name: $teamName))
        ->assertRecorded(new TeamCreated(userUuid: $userUuid, name: $teamName, personalTeam: false))
        ->aggregateRoot();

    expect($team->name)->toBe($teamName)
        ->and($team->userUuid)->toBe($userUuid)
        ->and($team->personalTeam)->toBe(false);
});