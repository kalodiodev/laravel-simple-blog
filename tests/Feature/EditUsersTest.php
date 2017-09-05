<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class EditUsersTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $user;

    protected $update_data = [
        'name' => 'New User name',
        'email' => 'newmail@example.com',
        'about' => 'New user about info',
        'profession' => 'New profession',
        'country' => 'New country',
        'role' => 2
    ];

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    
    /** @test */
    public function an_authorized_user_can_edit_user()
    {
        $this->signInAdmin();

        $response = $this->get(route('users.edit', ['user' => $this->user->id]))
            ->assertStatus(200);

        $response->assertViewIs('users.edit');
        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
    }

    /** @test */
    public function an_authorized_user_can_update_user()
    {
        $this->signInAdmin();

        $this->patch(route('users.update', ['user' => $this->user->id]), $this->update_data)
            ->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $this->update_data['name'],
            'email' => $this->update_data['email'],
            'about' => $this->update_data['about'],
            'profession' => $this->update_data['profession'],
            'country' => $this->update_data['country'],
            'role_id' => $this->update_data['role']
        ]);
    }

    /** @test */
    public function user_name_cannot_be_empty()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_has_a_name_of_limited_length()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'name' => str_random(200)
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_email_cannot_be_empty()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'email' => ''
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_has_an_email_of_limited_length()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'email' => str_random(200) . '@example.com'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_email_must_be_an_email()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'email' => str_random(20)
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'test@example.com']);

        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'email' => 'test@example.com'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function an_authorized_user_can_update_user_with_unchanged_email()
    {
        $this->signInAdmin();

        $this->patch(route('users.update', ['user' => $this->user->id]), [
            'name' => 'New User name',
            'email' => $this->user->email,
            'about' => 'New user about info',
            'profession' => 'New profession',
            'country' => 'New country',
            'role' => 2
        ])->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $this->update_data['name'],
            'email' => $this->user->email,
            'about' => $this->update_data['about'],
            'profession' => $this->update_data['profession'],
            'country' => $this->update_data['country'],
            'role_id' => $this->update_data['role']
        ]);
    }

    /** @test */
    public function an_authorized_user_can_add_user_avatar()
    {
        Storage::fake('testfs');
        $user = factory(User::class)->create();

        $this->signInAdmin();

        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $this->patch(route('users.update', ['user' => $user->id]), [
            'name' => 'New User name',
            'email' => 'newmail@example.com',
            'role' => 2,
            'avatar' => $avatar
        ])->assertStatus(302);

        $user->refresh();

        $this->assertNotNull($user->avatar, "User's avatar cannot be null");
        Storage::disk('testfs')->assertExists('images/avatar/' . $user->avatar);
    }

    /** @test */
    public function an_authorized_user_cannot_upload_invalid_user_avatar()
    {
        Storage::fake('testfs');
        $user = factory(User::class)->create();

        $this->signInAdmin();

        $avatar = UploadedFile::fake()->image('avatar.pdf');

        $response = $this->patch(route('users.update', ['user' => $user->id]), [
            'name' => 'New User name',
            'email' => 'newmail@example.com',
            'role' => 2,
            'avatar' => $avatar
        ]);

        $response->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function an_authorized_user_can_remove_user_avatar()
    {
        Storage::fake('testfs');
        UploadedFile::fake()->image('avatar.jpg')->storeAs('images/avatar/', 'avatar.jpg');

        $user = factory(User::class)->create(['avatar' => 'avatar.jpg']);

        $this->signInAdmin();

        $this->patch(route('users.update', ['user' => $user->id]), [
            'name' => 'New User name',
            'email' => 'newmail@example.com',
            'role' => 2,
            'removeavatar' => 'on'
        ]);

        $user->refresh();

        $this->assertNull($user->avatar, 'User\'s avatar filename must be null');

        Storage::disk('testfs')->assertMissing('images/avatar/avatar.jpg');
    }

    /** @test */
    public function an_authorized_user_can_update_user_avatar()
    {
        Storage::fake('testfs');
        // Current avatar
        UploadedFile::fake()->image('avatar.jpg')->storeAs('images/avatar/', 'avatar.jpg');
        // New avatar
        $new_avatar = UploadedFile::fake()->image('new_avatar.jpg');

        $user = factory(User::class)->create(['avatar' => 'avatar.jpg']);

        $this->signInAdmin();

        $this->patch(route('users.update', ['user' => $user->id]), [
            'name' => 'New User name',
            'email' => 'newmail@example.com',
            'role' => 2,
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
    public function an_unauthenticated_user_cannot_edit_user()
    {
        $this->get(route('users.edit', ['user' => $this->user->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_user()
    {
        $this->patch(route('users.update', ['user' => $this->user->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_edit_user()
    {
        $this->signInGuest();

        $this->get(route('users.edit', ['user' => $this->user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_user()
    {
        $this->signInGuest();

        $this->patch(route('users.update', ['user' => $this->user->id]), $this->update_data)
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_may_change_user_password()
    {
        $this->signInAdmin();

        $new_password = '123456';

        $this->patch(route('users.update', ['user' => $this->user->id]), [
            'name' => 'New User name',
            'email' => $this->user->email,
            'role' => '1',
            'password' => $new_password,
            'password_confirmation' => $new_password
        ])->assertStatus(302);
    }

    /** @test */
    public function user_new_password_should_match_password_confirmation()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'password' => '123456',
            'password_confirmation' => '000000'
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_new_password_should_be_at_least_six_characters_long()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);

        $response->assertSessionHasErrors('password');
    }
}