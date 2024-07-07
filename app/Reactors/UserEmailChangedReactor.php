<?php

namespace App\Reactors;

use App\Models\User;
use App\StorableEvents\UserEmailChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class UserEmailChangedReactor extends Reactor implements ShouldQueue
{
    public function onUserEmailChanged(UserEmailChanged $event)
    {
        $user = User::where('uuid', $event->aggregateRootUuid())->first();

        $user->sendEmailVerificationNotification();
    }
}
