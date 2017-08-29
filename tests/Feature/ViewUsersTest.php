<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ViewUsersTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $user;

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
    public function an_authorized_user_can_view_users_list()
    {
        $this->signInAdmin();

        $response = $this->get(route('users.index'))
            ->assertStatus(200);

        $response->assertViewIs('users.index');
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_users_list()
    {
        $this->get(route('users.index'))->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_users_list()
    {
        $this->signInGuest();

        $this->get(route('users.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_user()
    {
        $this->signInAdmin();

        $response = $this->get(route('users.show', ['user' => $this->user->id]))
            ->assertStatus(200);

        $response->assertViewIs('users.show');
        $response->assertSee($this->user->email);
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_user()
    {
        $this->signInGuest();

        $this->get(route('users.show', ['user' => $this->user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_user()
    {
        $this->get(route('users.show', ['user' => $this->user->id]))
            ->assertRedirect('/login');
    }
}