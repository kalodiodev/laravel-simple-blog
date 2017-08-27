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
    public function an_unauthenticated_user_cannot_edit_user()
    {
        $this->get(route('users.edit', ['user' => $this->user->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_edit_user()
    {
        $this->signInGuest();

        $this->get(route('users.edit', ['user' => $this->user->id]))
            ->assertStatus(403);
    }
}