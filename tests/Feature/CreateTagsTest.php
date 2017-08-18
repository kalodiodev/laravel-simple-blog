<?php

namespace Tests\Feature;

use App\Tag;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTagsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $tag;

    public function setUp()
    {
        parent::setUp();

        $this->tag = factory(Tag::class)->make();
    }

    /** @test */
    public function an_authorized_user_can_create_tag_when_has_permission()
    {
        $this->signInAdmin();

        $response = $this->get(route('tag.create'))->assertStatus(200);

        $response->assertViewIs('tags.create');
    }

    /** @test */
    public function an_authorized_user_can_store_tag_when_has_permission()
    {
        $this->signInAdmin();

        $response = $this->post(route('tag.store'), $this->tag->toArray())
            ->assertRedirect(route('tag.index'));

        $this->get($response->headers->get('Location'))
            ->assertSee($this->tag->name);
    }

    /** @test */
    public function an_unauthorized_user_cannot_create_tag()
    {
        $this->signInGuest();

        $this->get(route('tag.create'))->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_tag()
    {
        $this->signInGuest();

        $this->post(route('tag.store'), $this->tag->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('tags', [
            'name' => $this->tag->name
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_tag()
    {
        $this->get(route('tag.create'))->assertRedirect('/login');

        $this->post(route('tag.store'))->assertRedirect('/login');
    }
}