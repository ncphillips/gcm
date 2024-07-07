<?php

namespace Tests\Feature;

use App\Aggregates\UserAggregate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;
use Tests\TestCase;

class InviteTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_members_can_be_invited_to_team(): void
    {
        Mail::fake();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('addTeamMemberForm', [
                'email' => 'test@example.com',
                'role' => 'admin',
            ])->call('addTeamMember');

        Mail::assertSent(TeamInvitation::class);

        $this->assertCount(1, $user->currentTeam->fresh()->teamInvitations);
    }

    public function test_team_member_invitations_can_be_cancelled(): void
    {
        Mail::fake();

        UserAggregate::retrieve($uuid = (string) Str::uuid())
            ->create('Bob', 'bob@example.com', 'password-hash')
            ->persist();

        $this->actingAs($user = User::where('uuid', $uuid)->first());

        // Add the team member...
        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('addTeamMemberForm', [
                'email' => 'test@example.com',
                'role' => 'admin',
            ])->call('addTeamMember');

        $invitationId = $user->currentTeam->fresh()->teamInvitations->first()->id;

        // Cancel the team invitation...
        $component->call('cancelTeamInvitation', $invitationId);

        $this->assertCount(0, $user->currentTeam->fresh()->teamInvitations);
    }
}
