<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUsersTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authorized_user_can_create_a_user()
    {
        $this->signInAdmin();

        $response = $this->get(route('users.create'))
            ->assertStatus(200);

        $response->assertViewIs('users.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_create_a_user()
    {
        $this->signInGuest();

        $this->get(route('users.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_user()
    {
        $this->get(route('users.create'))
            ->assertRedirect('/login');
    }
}