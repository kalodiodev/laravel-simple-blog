<?php

use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditProfilesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_edit_own_profile()
    {
        $user = $this->signInGuest();

        $response = $this->get(route('profile.edit', ['user' => $user->id]))
            ->assertStatus(200);

        $response->assertViewIs('profiles.edit');
    }

    /** @test */
    public function a_user_cannot_edit_others_profile()
    {
        $user = factory(\App\User::class)->create();
        $this->signInGuest();

        $this->get(route('profile.edit', ['user' => $user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_profile()
    {
        $user = factory(\App\User::class)->create();

        $this->get(route('profile.edit', ['user' => $user->id]))
            ->assertRedirect('/login');
    }
}