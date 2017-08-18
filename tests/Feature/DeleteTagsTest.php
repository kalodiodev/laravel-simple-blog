<?php

namespace Tests\Feature;

use App\Tag;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteTagsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $tag;

    public function setUp()
    {
        parent::setUp();

        $this->tag = factory(Tag::class)->create();
    }

    /** @test */
    public function an_authorized_user_can_delete_tag()
    {
        $this->signInAdmin();

        $this->delete(route('tag.delete', ['tag' => $this->tag->name]))
            ->assertRedirect(route('tag.index'));

        $this->assertDatabaseMissing('tags', [
            'id' => $this->tag->id
        ]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_tag()
    {
        $this->signInGuest();

        $this->delete(route('tag.delete', ['tag' => $this->tag->name]))
            ->assertStatus(403);

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_tag()
    {
        $this->delete(route('tag.delete', ['tag' => $this->tag->name]))
            ->assertRedirect('/login');

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id
        ]);
    }
}