<?php

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $user = factory(User::class)->create();
        $this->signInGuest();

        $this->get(route('profile.edit', ['user' => $user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_profile()
    {
        $user = factory(User::class)->create();

        $this->get(route('profile.edit', ['user' => $user->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authorized_user_can_edit_other_users_profile()
    {
        $user = factory(User::class)->create();
        $this->signInAdmin();

        $response = $this->get(route('profile.edit', ['user' => $user->id]))
            ->assertStatus(200);

        $response->assertViewIs('profiles.edit');
    }

    /** @test */
    public function an_authorized_user_can_update_other_users_profile()
    {
        $user = factory(User::class)->create();
        $this->signInAdmin();

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
        $user = factory(User::class)->create();
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
        $user = factory(User::class)->create();

        $this->patch(route('profile.update', ['user' => $user->id]), $this->update_data)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_add_avatar()
    {
        Storage::fake('testfs');

        $user = $this->signInGuest();
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $this->patch(route('profile.update', ['user' => $user->id]), [
            'name' => 'User name',
            'avatar' => $avatar
        ])->assertStatus(302);

        $user->refresh();

        $this->assertNotNull($user->avatar, "User's avatar cannot be null");
        Storage::disk('testfs')->assertExists('images/avatar/' . $user->avatar);
    }
    
    /** @test */
    public function an_authenticated_user_cannot_add_invalid_avatar()
    {
        Storage::fake('testfs');

        $user = $this->signInGuest();
        $avatar = UploadedFile::fake()->image('avatar.pdf');

        $response = $this->patch(route('profile.update', ['user' => $user->id]), [
            'name' => 'User name',
            'avatar' => $avatar
        ]);

        $response->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function an_authenticated_user_can_remove_avatar()
    {
        Storage::fake('testfs');
        UploadedFile::fake()->image('avatar.jpg')->storeAs('images/avatar/', 'avatar.jpg');

        $user = $this->signInGuest(['avatar' => 'avatar.jpg']);

        $this->patch(route('profile.update', ['user' => $user->id]), [
            'name' => 'User name',
            'removeavatar' => 'on'
        ]);

        $user->refresh();

        $this->assertNull($user->avatar, 'User\'s avatar filename must be null');

        Storage::disk('testfs')->assertMissing('images/avatar/avatar.jpg');
    }

    /** @test */
    public function an_authenticated_user_can_update_avatar()
    {
        Storage::fake('testfs');
        // Current avatar
        UploadedFile::fake()->image('avatar.jpg')->storeAs('images/avatar/', 'avatar.jpg');
        // New avatar
        $new_avatar = UploadedFile::fake()->image('new_avatar.jpg');

        $user = $this->signInGuest(['avatar' => 'avatar.jpg']);

        $this->patch(route('profile.update', ['user' => $user->id]), [
            'name' => 'User name',
            'avatar' => $new_avatar
        ]);

        $user->refresh();

        $this->assertStringEndsWith('new_avatar.jpg',
            $user->avatar, 'New avatar filename must end with new_avatar.jpg after timestamp');

        // New avatar must be stored
        Storage::disk('testfs')->assertExists('images/avatar/' . $user->avatar);

        // Old avatar must be deleted
        Storage::disk('testfs')->assertMissing('images/avatar/avatar.jpg');
    }

    /** @test */
    public function a_profile_has_name_of_limited_length()
    {
        $user = $this->signInGuest();

        $response = $this->update_profile($user, [
            'name' => str_random(200)
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function profile_name_is_required()
    {
        $user = $this->signInGuest();

        $response = $this->update_profile($user, [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_profile_may_have_about_of_limited_length()
    {
        $user = $this->signInGuest();

        $response = $this->update_profile($user, [
            'about' => str_random(200)
        ]);

        $response->assertSessionHasErrors('about');
    }

    /** @test */
    public function a_profile_may_have_profession_of_limited_length()
    {
        $user = $this->signInGuest();

        $response = $this->update_profile($user, [
            'profession' => str_random(200)
        ]);

        $response->assertSessionHasErrors('profession');
    }

    /** @test */
    public function a_profile_may_have_country_of_limited_length()
    {
        $user = $this->signInGuest();

        $response = $this->update_profile($user, [
            'country' => str_random(200)
        ]);

        $response->assertSessionHasErrors('country');
    }

    protected function update_profile(User $user, array $data)
    {
        return $this->patch(route('profile.update', ['user' => $user->id]), $data);
    }
}