<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexTagsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authorized_user_can_view_tags_index_when_has_permission()
    {
        $user = factory(User::class)->create();
        $this->giveUserRole($user, 'admin');
        $this->signIn($user);

        $response = $this->get(route('tag.index'))
            ->assertStatus(200);

        $response->assertViewIs('tags.index');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_tags_index()
    {
        $user = factory(User::class)->create();
        $this->giveUserRole($user, 'guest');
        $this->signIn($user);

        $this->get(route('tag.index'))->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_tags_index()
    {
        $this->get(route('tag.index'))->assertRedirect("/login");
    }
}