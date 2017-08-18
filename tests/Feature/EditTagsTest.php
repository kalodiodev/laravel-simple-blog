<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class EditTagsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $tag;

    // Data used to update tag
    protected $update_data = [
        'name' => 'newtag',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->tag = factory(\App\Tag::class)->create();
    }
    
    /** @test */
    public function an_authorized_user_can_edit_tag()
    {
        $this->signInAdmin();
        
        $response = $this->get(route('tag.edit', ['tag' => $this->tag->name]))
            ->assertStatus(200);
        
        $response->assertViewIs('tags.edit')
            ->assertSee($this->tag->name);
    }

    /** @test */
    public function an_authorized_user_can_update_tag()
    {
        $this->signInAdmin();

        $this->patch(route('tag.update', ['tag' => $this->tag->name]), $this->update_data)
            ->assertStatus(302);

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id,
            'name' => $this->update_data['name']
        ]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_edit_tag()
    {
        $this->signInGuest();

        $this->get(route('tag.edit', ['tag' => $this->tag->name]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_tag()
    {
        $this->signInGuest();

        $this->patch(route('tag.update', ['tag' => $this->tag->name]), $this->update_data)
            ->assertStatus(403);

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id,
            'name' => $this->tag->name
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_tag()
    {
        $this->get(route('tag.edit', ['tag' => $this->tag->name]))
            ->assertRedirect('/login');

        $this->patch(route('tag.update', ['tag' => $this->tag->name]), $this->update_data)
            ->assertRedirect('/login');
    }
}
