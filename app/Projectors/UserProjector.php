<?php

namespace App\Projectors;

use App\Models\Team;
use App\Models\User;
use App\StorableEvents\UserCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserProjector extends Projector
{
    public function onUserCreated(UserCreated $event)
    {
        DB::transaction(function () use ($event) {
            return tap(User::create([
                'uuid' => $event->aggregateRootUuid(),
                'name' => $event->name,
                'email' => $event->email,
                'password' => $event->passwordHash,
            ]), function (User $user) {
                $user->ownedTeams()->save(Team::forceCreate([
                    'uuid' => (string) Str::uuid(),
                    'user_id' => $user->id,
                    'name' => explode(' ', $user->name, 2)[0] . "'s Team",
                    'personal_team' => true,
                ]));
            });
        });
    }
}
