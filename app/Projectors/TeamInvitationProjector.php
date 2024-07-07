<?php

namespace App\Projectors;

use App\Models\Team;
use App\StorableEvents\TeamMemberInvited;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Mail\TeamInvitation;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TeamInvitationProjector extends Projector
{
    public function onTeamMemberInvited(TeamMemberInvited $event)
    {
        $team = Team::where('uuid', $event->aggregateRootUuid())->first();

        $invitation = $team->teamInvitations()->create([
            'email' => $event->email,
            'role' => $event->role,
        ]);

        Mail::to($event->email)->send(new TeamInvitation($invitation));
    }
}
