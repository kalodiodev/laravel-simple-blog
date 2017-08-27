<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;
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
}