<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ViewProfilesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_profile()
    {
        $user = factory(User::class)->create();

        $response = $this->get('/profile/' . $user->id)
            ->assertStatus(200);

        $response->assertViewIs('profiles.show');
        $response->assertDontSee('Email');
    }

    /** @test */
    public function an_authorized_user_can_view_other_users_detailed_profile()
    {
        $user = factory(User::class)->create();

        $this->signInAdmin();

        $response = $this->get('/profile/' . $user->id)
            ->assertStatus(200);

        $response->assertViewIs('profiles.show');
        $response->assertSee('Email');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_other_users_detailed_profile()
    {
        $user = factory(User::class)->create();

        $this->signInGuest();

        $response = $this->get('/profile/' . $user->id)
            ->assertStatus(200);

        $response->assertViewIs('profiles.show');
        $response->assertDontSee('Email');
    }

    /** @test */
    public function a_user_can_see_own_detailed_profile()
    {
        $user = $this->signInGuest();

        $response = $this->get('/profile/' . $user->id)
            ->assertStatus(200);

        $response->assertViewIs('profiles.show');
        $response->assertSee('Email');
    }
}