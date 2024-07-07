<?php

namespace Tests\Feature;

use App\Aggregates\UserAggregate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        // Get last created user
        $user = User::latest()->first();
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertNotNull($user->uuid);

        // Check that aggregate was created.
        $userAggregate = UserAggregate::retrieve($user->uuid);
        $this->assertEquals('Test User', $userAggregate->name);
        $this->assertEquals('test@example.com', $userAggregate->email);

        $team = $user->ownedTeams()->first();
        $this->assertNotNull($team);
    }

    public function test_email_already_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
