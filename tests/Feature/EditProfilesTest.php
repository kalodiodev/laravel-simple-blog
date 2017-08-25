<?php

use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditProfilesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $update_data = [
        'name' => 'New name',
        'about' => 'New about',
        'country' => 'Country',
        'profession' => 'My profession'
    ];

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

    /** @test */
    public function a_user_can_update_own_profile()
    {
        $user = $this->signInGuest();

        $this->patch(route('profile.update', ['user' => $user->id]), $this->update_data)
            ->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $this->update_data['name'],
            'about' => $this->update_data['about'],
            'country' => $this->update_data['country'],
            'profession' => $this->update_data['profession']
        ]);
    }

    /** @test */
    public function a_user_cannot_update_others_profile()
    {
        $user = factory(\App\User::class)->create();
        $this->signInGuest();

        $this->patch(route('profile.update', ['user' => $user->id]), $this->update_data)
            ->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'about' => $user->about,
            'country' => $user->country,
            'profession' => $user->profession
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_profile()
    {
        $user = factory(\App\User::class)->create();

        $this->patch(route('profile.update', ['user' => $user->id]), $this->update_data)
            ->assertRedirect('/login');
    }
}