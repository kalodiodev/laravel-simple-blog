<?php

namespace Tests\Feature;

use Tests\FakeImage;
use Tests\IntegrationTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class AdminDeleteImagesTest extends IntegrationTestCase
{
    use DatabaseMigrations, FakeImage;

    protected $image;

    public function setUp()
    {
        parent::setUp();
        
        $this->image = $this->addFakeImage();
    }

    /** @test */
    public function an_admin_can_delete_image()
    {
        $this->signInAdmin();

        $this->delete(route('images.admin.delete', ['image' => $this->image->id]))
            ->assertStatus(302);

        Storage::disk('testfs')->assertMissing($this->image->path . $this->image->filename);
        Storage::disk('testfs')->assertMissing($this->image->path . $this->image->thumbnail);

        $this->assertDatabaseMissing('images', [
            'id' => $this->image->id,
            'filename' => $this->image->filename,
            'thumbnail' => $this->image->thumbnail
        ]);
    }

    /** @test */
    public function an_author_cannot_delete_image_using_admin_delete_route()
    {
        $this->signInAuthor();

        $this->delete(route('images.admin.delete', ['image' => $this->image->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_author_cannot_delete_image_owns_using_admin_delete_route()
    {
        $user = $this->signInAuthor();

        $image = $this->addFakeImage($user);

        $this->delete(route('images.admin.delete', ['image' => $image->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_should_be_redirected_to_login()
    {
        $image = $this->addFakeImage();

        $this->delete(route('images.admin.delete', ['image' => $image->id]))
            ->assertRedirect('/login');
    }
}