<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\IntegrationTestCase;
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

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        parent::tearDown();
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
    public function user_may_have_about_of_limited_length()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'about' => str_random(200)
        ]);

        $response->assertSessionHasErrors('about');
    }

    /** @test */
    public function user_may_have_profession_of_limited_length()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'profession' => str_random(51)
        ]);

        $response->assertSessionHasErrors('profession');
    }

    /** @test */
    public function user_may_have_country_of_limited_length()
    {
        $this->signInAdmin();

        $response = $this->patch(route('users.update', ['user' => $this->user->id]), [
            'country' => str_random(26)
        ]);

        $response->assertSessionHasErrors('country');
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
}